<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ConfigurationRepository extends EntityRepository
{
    public function get($slug)
    {
        return $this->findOneBy(
            [
                'slug' => $slug,
            ]
        );
    }
}
