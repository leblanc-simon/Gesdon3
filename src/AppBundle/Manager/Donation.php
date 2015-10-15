<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Contributor;
use AppBundle\Entity\Donation as DonationEntity;
use AppBundle\Repository\AddressRepository;
use AppBundle\Repository\ContributorRepository;
use AppBundle\Repository\DonationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class Donation
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
     * @var EntityManagerInterface
     */
    private $entity_manager;

    /**
     * @var FlashBagInterface
     */
    private $session_flashbag;

    /**
     * @var DonationEntity
     */
    private $donation;

    /**
     * @param EntityManagerInterface $entity_manager
     * @param DonationRepository     $donation_repository
     * @param ContributorRepository  $contributor_repository
     * @param AddressRepository      $address_repository
     * @param FlashBagInterface      $session_flashbag
     */
    public function __construct(
        EntityManagerInterface $entity_manager,
        DonationRepository $donation_repository,
        ContributorRepository $contributor_repository,
        AddressRepository $address_repository,
        FlashBagInterface $session_flashbag
    ) {
        $this->entity_manager = $entity_manager;
        $this->donation_repository = $donation_repository;
        $this->contributor_repository = $contributor_repository;
        $this->address_repository = $address_repository;
        $this->session_flashbag = $session_flashbag;
    }

    /**
     * @return DonationEntity
     */
    public function newEntity()
    {
        return (new DonationEntity())->setUuid('MANUAL-'.sha1(uniqid('manual', true)));
    }

    /**
     * Set the entity to manage
     * @param DonationEntity $donation
     * @return $this
     */
    public function setDonation(DonationEntity $donation)
    {
        $this->donation = $donation;
        return $this;
    }

    /**
     * @param string $type edit|add
     * @return $this
     */
    public function checkIfContributorExist($type)
    {
        if (null === $this->donation) {
            throw new \RuntimeException('Please, set donation before to use checkIfContributorExist');
        }

        if (in_array($type, ['edit', 'add']) === false) {
            throw new \RuntimeException('The type must be add or edit');
        }

        $current_contributor = $this->donation->getContributor();

        $contributor_already_exist = false;
        if ('add' === $type) {
            // check if the contributor already exist and use the existant if necessary
            $contributor_already_exist = $this->setContributorWithAnExisting($current_contributor);
        }

        if (true === $contributor_already_exist) {
            $this->setAddressWithAnExisting($this->donation->getContributor());
        }

        return $this;
    }

    /**
     * @param Contributor $current_contributor
     * @return bool true if the contributor already exist in database, false else
     */
    private function setContributorWithAnExisting(Contributor $current_contributor)
    {
        if (null !== $current_contributor->getEmail()) {
            $contributor = $this->contributor_repository->findOneByEmail($current_contributor->getEmail());
        } else {
            $contributor = $this->contributor_repository->findOneWithoutEmail(
                $current_contributor->getFirstname(),
                $current_contributor->getLastname(),
                $current_contributor->getCompany()
            );
        }

        if (null !== $contributor) {
            $contributor->setFirstname($current_contributor->getFirstname());
            $contributor->setLastname($current_contributor->getLastname());
            $contributor->setCompany($current_contributor->getCompany());
            $contributor->addAddress($current_contributor->getSingleAddress());
            $this->donation->setContributor($contributor);
            return true;
        }

        return false;
    }

    /**
     * @param Contributor $contributor
     * @return bool true if the address already exist in database, false else
     */
    private function setAddressWithAnExisting(Contributor $contributor)
    {
        $current_address = $contributor->getSingleAddress();
        $address = $this->address_repository->findOneIdentical($current_address);

        if (null !== $address) {
            $contributor
                ->removeAddress($current_address)
                ->addAddress($address);
            $this->donation->setContributor($contributor);
            return true;
        }

        return false;
    }

    /**
     * Save the current donation
     * @return $this
     */
    public function save()
    {
        if (null === $this->donation) {
            throw new \RuntimeException('Please, set donation before to use save');
        }

        $this->entity_manager->persist($this->donation);
        $this->entity_manager->flush();

        $this->session_flashbag->add('success', 'item.saved');

        return $this;
    }

    /**
     * Remove the current donation
     * @return $this
     */
    public function remove()
    {
        if (null === $this->donation) {
            throw new \RuntimeException('Please, set donation before to use remove');
        }

        $this->entity_manager->remove($this->donation);
        $this->entity_manager->flush();

        $this->session_flashbag->add('success', 'item.removed');

        return $this;
    }
}