<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Configuration;
use Doctrine\ORM\EntityRepository;

class ConfigurationRepository extends EntityRepository
{
    /**
     * @param $slug
     * @return Configuration
     */
    public function get($slug)
    {
        return $this->findOneBy(
            [
                'slug' => $slug,
            ]
        );
    }
}
