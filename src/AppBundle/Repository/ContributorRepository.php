<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Contributor;
use Doctrine\ORM\EntityRepository;

class ContributorRepository extends EntityRepository
{
    public function getQueryForAll()
    {
        return $this
            ->createQueryBuilder('c')
            ->addOrderBy('c.lastname', 'ASC')
            ->addOrderBy('c.firstname', 'ASC')
            ->addOrderBy('c.company', 'ASC')
            ->getQuery()
            ;
    }

    /**
     * @param $firstname
     * @param $lastname
     * @param $company
     * @return Contributor|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneWithoutEmail($firstname, $lastname, $company)
    {
        $qb = $this->createQueryBuilder('c');

        // email must be empty : null or empty
        $or_email = $qb->expr()->orX();
        $or_email
            ->add($qb->expr()->eq('c.email', ''))
            ->add($qb->expr()->isNull('c.email'))
        ;

        $qb
            ->where('c.firstname = :firstname')
            ->andWhere('c.lastname = :lastname')
            ->andWhere($or_email)
        ;

        if (true === empty($company)) {
            // if company is empty, check real empty : null or empty
            $or_company = $qb->expr()->orX();
            $or_company
                ->add($qb->expr()->eq('c.company', ''))
                ->add($qb->expr()->isNull('c.company'))
            ;
            $qb->andWhere($or_company);
        } else {
            // else, check the company name
            $qb
                ->andWhere('c.company = :company')
                ->setParameter('company', $company)
            ;
        }

        $qb->setParameters([
            'firstname' => $firstname,
            'lastname' => $lastname,
        ]);

        return $qb->getQuery()->getOneOrNullResult();
    }
}