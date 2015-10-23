<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Donation;
use Doctrine\ORM\EntityRepository;

class DonationRepository extends EntityRepository
{
    /**
     * Return the query for all donation
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQueryForAll()
    {
        return $this
            ->createQueryBuilder('d')
            ->addOrderBy('d.created_at', 'DESC')
            ->getQuery()
        ;
    }

    /**
     * @param           $email
     * @param \DateTime $begin
     * @param \DateTime $end
     * @return Donation[]
     */
    public function findAllFromEmailAndDateForReceipt($email, \DateTime $begin, \DateTime $end)
    {
        $begin->setTime(0, 0, 0);
        $end->setTime(23, 59, 59);

        return $this
            ->createQueryBuilder('d')
            ->select('d, c')
            ->innerJoin('d.contributor', 'c')
            ->where('c.email = :email')
            ->andWhere('d.converted = :converted')
            ->andWhere('d.created_at BETWEEN :begin AND :end')
            ->setParameters([
                'email' => $email,
                'begin' => $begin,
                'end' => $end,
                'converted' => false,
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}