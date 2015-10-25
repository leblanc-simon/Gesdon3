<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Address;
use AppBundle\Entity\Contributor;
use AppBundle\Entity\ContributorType;
use AppBundle\Entity\Donation;
use AppBundle\Repository\AddressRepository;
use AppBundle\Repository\ContributorRepository;
use AppBundle\Repository\DonationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ApiDonation
{
    /**
     * @var DonationRepository
     */
    private $donation_repository;

    /**
     * @var ContributorRepository
     */
    private $contributor_repository;

    /**
     * @var AddressRepository
     */
    private $address_repository;

    /**
     * @var EntityRepository
     */
    private $payment_type_repository;

    /**
     * @var EntityRepository
     */
    private $contributor_type_repository;

    /**
     * @var EntityManagerInterface
     */
    private $entity_manager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var array
     */
    private $datas;

    /**
     * @param EntityManagerInterface $entity_manager
     * @param DonationRepository     $donation_repository
     * @param ContributorRepository  $contributor_repository
     * @param AddressRepository      $address_repository
     * @param EntityRepository       $contributor_type_repository
     * @param EntityRepository       $payment_type_repository
     * @param LoggerInterface        $logger
     */
    public function __construct(
        EntityManagerInterface $entity_manager,
        DonationRepository $donation_repository,
        ContributorRepository $contributor_repository,
        AddressRepository $address_repository,
        EntityRepository $contributor_type_repository,
        EntityRepository $payment_type_repository,
        LoggerInterface $logger
    ) {
        $this->entity_manager = $entity_manager;
        $this->donation_repository = $donation_repository;
        $this->contributor_repository = $contributor_repository;
        $this->address_repository = $address_repository;
        $this->contributor_type_repository = $contributor_type_repository;
        $this->payment_type_repository = $payment_type_repository;
        $this->logger = $logger;
    }

    /**
     * Extract the value the request
     *
     * @param Request $request
     * @return $this
     * @throws \InvalidArgumentException if a required parameters is not set
     */
    public function extractFromRequest(Request $request)
    {
        try {
            $datas_to_extract = [
                // name => required
                'firstname' => false,
                'lastname' => false,
                'company' => false,
                'email' => true,
                'contributor_type' => false,
                'street' => true,
                'additional' => false,
                'zip_code' => true,
                'city' => true,
                'country' => true,
                'amount' => true,
                'fee' => false,
                'via' => true,
                'payment_type' => true,
                'reference' => false,
            ];

            $this->datas = [];

            foreach ($datas_to_extract as $name => $required) {
                $value = trim($request->get($name));
                if (true === $required && empty($value) === true) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            '%s is required',
                            $name
                        )
                    );
                }

                $this->datas[$name] = trim($value);
            }

            $this->checkValues();
        } catch (\InvalidArgumentException $e) {
            $this->logger->error($e->getMessage(), $request->request->all());
            throw $e;
        }

        return $this;
    }

    /**
     * Save the donation
     */
    public function save()
    {
        try {
            $contributor = $this->findOrCreateContributor();
            $this->entity_manager->persist($contributor);

            $address = $this->findOrCreateAddress($contributor);
            $this->entity_manager->persist($address);

            $donation = $this->getDonation($contributor);
            $this->entity_manager->persist($donation);

            $this->entity_manager->flush();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * Check the value from request
     *
     * @throws \InvalidArgumentException if a required parameters is not set
     */
    private function checkValues()
    {
        // At least one of the 3 field must have a value (firstname, lastname, company)
        if (
            empty($this->datas['firstname']) === true &&
            empty($this->datas['lastname']) === true &&
            empty($this->datas['company']) === true
        ) {
            throw new \InvalidArgumentException(
                'At least one of the 3 field must have a value (firstname, lastname, company)'
            );
        }

        // Amount must be numeric > 0
        if (is_numeric($this->datas['amount']) === false) {
            throw new \InvalidArgumentException('amount must be a numeric');
        }
        if ($this->datas['amount'] <= 0) {
            throw new \InvalidArgumentException('amount must greather than 0');
        }

        // Fee must be empty or numeric
        if (empty($this->datas['fee']) === true) {
            $this->datas['fee'] = 0;
        } elseif (is_numeric($this->datas['fee']) === false) {
            throw new \InvalidArgumentException('fee must be a numeric');
        }

        // contributor_type must exist
        if (empty($this->datas['contributor_type']) === true) {
            $this->datas['contributor_type'] = ContributorType::DEFAULT_TYPE;
        }
        $contributor_type = $this->contributor_type_repository->findOneBySlug($this->datas['contributor_type']);
        if (null === $contributor_type) {
            throw new \InvalidArgumentException('contributor type must exist');
        }
        $this->datas['contributor_type'] = $contributor_type;

        // payment_type must exist
        $payment_type = $this->payment_type_repository->findOneBySlug($this->datas['payment_type']);
        if (null === $payment_type) {
            throw new \InvalidArgumentException('payment type must exist');
        }
        $this->datas['payment_type'] = $payment_type;

        // Country must be a ISO Code
        $this->datas['country'] = strtoupper($this->datas['country']);
        if (preg_match('/^[A-Z]{2}$/', $this->datas['country']) === 0) {
            throw new \InvalidArgumentException('country must be an ISO Code of country');
        }
    }

    /**
     * @return Contributor
     */
    private function findOrCreateContributor()
    {
        $contributor = $this->contributor_repository->findOneBy([
            'email' => $this->datas['email'],
        ]);

        if (null === $contributor) {
            $contributor = new Contributor();
            $contributor->setEmail($this->datas['email']);
        }

        $property_access = PropertyAccess::createPropertyAccessorBuilder()->getPropertyAccessor();
        foreach (['firstname', 'lastname', 'company', 'contributor_type'] as $key) {
            if (null !== $this->datas[$key]) {
                $property_access->setValue($contributor, $key, $this->datas[$key]);
            }
        }

        return $contributor;
    }

    /**
     * @param Contributor $contributor
     * @return Address
     */
    private function findOrCreateAddress(Contributor $contributor)
    {
        $address = new Address();
        $address
            ->setContributor($contributor)
            ->setStreet($this->datas['street'])
            ->setAdditional($this->datas['additional'])
            ->setZipCode($this->datas['zip_code'])
            ->setCity($this->datas['city'])
            ->setCountry($this->datas['country'])
        ;

        if (null === $contributor->getId()) {
            return $address;
        }

        $existing_address = $this->address_repository->findOneIdentical($address);

        if (null === $existing_address) {
            return $address;
        }

        return $existing_address;
    }

    /**
     * @param Contributor $contributor
     * @return Donation
     */
    private function getDonation(Contributor $contributor)
    {
        $uuid = strtoupper($this->datas['payment_type']->getSlug()).
            '-'.sha1(uniqid('', true))
        ;

        $donation = new Donation();
        $donation
            ->setUuid($uuid)
            ->setContributor($contributor)
            ->setAmount($this->datas['amount'])
            ->setVia($this->datas['via'])
            ->setFee($this->datas['fee'])
            ->setReference($this->datas['reference'])
            ->setPaymentType($this->datas['payment_type'])
        ;

        return $donation;
    }
}
