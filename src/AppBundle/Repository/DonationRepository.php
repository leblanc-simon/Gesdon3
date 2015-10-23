<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DonationRepository extends EntityRepository
{
    public function getQueryForAll()
    {
        return $this
            ->createQueryBuilder('d')
            ->addOrderBy('d.created_at', 'DESC')
            ->getQuery()
        ;
    }
}