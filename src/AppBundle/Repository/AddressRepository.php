<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Address;
use Doctrine\ORM\EntityRepository;

class AddressRepository extends EntityRepository
{
    /**
     * @param Address $address
     * @return Address|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneIdentical(Address $address)
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.contributor = :contributor')
            ->andWhere('a.street = :street')
            ->andWhere('a.zip_code = :zip_code')
            ->andWhere('a.city = :city')
            ->andWhere('a.country = :country')
        ;

        $qb->setParameters([
            'contributor' => $address->getContributor(),
            'street' => $address->getStreet(),
            'zip_code' => $address->getZipCode(),
            'city' => $address->getCity(),
            'country' => $address->getCountry(),
        ]);

        if (null !== $address->getId()) {
            $qb
                ->andWhere('a.id != :address')
                ->setParameter('address', $address->getId())
            ;
        }

        if (true === empty($address->getAdditional())) {
            $or_additional = $qb->expr()->orX();
            $or_additional
                ->add($qb->expr()->eq('a.additional', ':additional'))
                ->add($qb->expr()->isNull('a.additional'))
            ;
            $qb
                ->andWhere($or_additional)
                ->setParameter('additional', '')
            ;
        } else {
            $qb
                ->andWhere('a.additional = :additional')
                ->setParameter('additional', $address->getAdditional())
            ;
        }

        return $qb->getQuery()->getOneOrNullResult();
    }
}