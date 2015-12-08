<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Address;
use AppBundle\Entity\Contributor;
use AppBundle\Entity\PaymentType;
use AppBundle\Repository\DonationRepository;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Receipt as ReceiptEntity;
use Psr\Log\LoggerInterface;

class Receipt
{
    /**
     * @var EntityManagerInterface
     */
    private $entity_manager;

    /**
     * @var DonationRepository
     */
    private $donation_repository;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        EntityManagerInterface $entity_manager,
        LoggerInterface $logger,
        DonationRepository $donation_repository,
        Configuration $configuration
    ) {
        $this->entity_manager = $entity_manager;
        $this->logger = $logger;
        $this->donation_repository = $donation_repository;
        $this->configuration = $configuration;
    }

    public function buildForEmail($email, \DateTime $begin, \DateTime $end)
    {
        $this->logger->debug('build receipt for email', [$email, $begin, $end]);

        $donations = $this->donation_repository->findAllFromEmailAndDateForReceipt($email, $begin, $end);
        if (0 === count($donations)) {
            $this->logger->info('no donation for email', [$email, $begin, $end]);
            return false;
        }

        $this->entity_manager->beginTransaction();

        $amount = 0;
        $contributor = null;
        $via = null;

        $receipt = new ReceiptEntity();

        foreach ($donations as $donation) {
            $amount += $donation->getAmount();
            $contributor = $donation->getContributor();
            $via = $donation->getVia();
            $payment_type = $donation->getPaymentType();

            $donation->setConverted(true);
            $this->entity_manager->persist($donation);

            $receipt->addDonation($donation);
        }

        if (null === $contributor) {
            $this->logger->error('no contributor found for email', [$email, $begin, $end]);
            return false;
        }

        $address = $contributor->getSingleAddress();
        if (null === $address || 0 === $address->getId()) {
            $this->logger->error('no address found for email', [$email, $begin, $end]);
            return false;
        }

        $this->buildReceipt(
            $receipt,
            $contributor,
            $address,
            $amount,
            $begin,
            $end,
            (bool)count($donations),
            $via,
            $payment_type
        );

        $this->entity_manager->flush();
        $this->entity_manager->commit();

        $this->logger->info('receipt created for email', [$email, $begin, $end, $amount]);

        return true;
    }

    /**
     * @param ReceiptEntity $receipt
     * @param Contributor $contributor
     * @param Address $address
     * @param float $amount
     * @param \DateTime $begin
     * @param \DateTime $end
     * @param bool $recurring
     * @param string $via
     * @param PaymentType $payment_type
     */
    private function buildReceipt(
        ReceiptEntity $receipt,
        Contributor $contributor,
        Address $address,
        $amount,
        \DateTime $begin,
        \DateTime $end,
        $recurring,
        $via,
        PaymentType $payment_type
    ) {
        $next_legal_number = (int)$this->configuration->get('next_legal_number');

        $receipt
            ->setLegalNumber($next_legal_number)
            ->setEmail($contributor->getEmail())
            ->setFirstname($contributor->getFirstname())
            ->setLastname($contributor->getLastname())
            ->setCompany($contributor->getCompany())
            ->setStreet($address->getStreet())
            ->setAdditional($address->getAdditional())
            ->setZipCode($address->getZipCode())
            ->setCity($address->getCity())
            ->setCountry($address->getCountry())
            ->setAmount($amount)
            ->setBeginDate($begin)
            ->setEndDate($end)
            ->setRecurring($recurring)
            ->setSended(false)
            ->setVia($via)
            ->setCreatedAt(new \DateTime())
            ->setContributor($contributor)
            ->setPaymentType($payment_type)
        ;

        $this->entity_manager->persist($receipt);

        $this->configuration->set('next_legal_number', $next_legal_number + 1);
    }
}