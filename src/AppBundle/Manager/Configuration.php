<?php

namespace AppBundle\Manager;

use AppBundle\Repository\ConfigurationRepository;
use Doctrine\ORM\EntityManagerInterface;

class Configuration
{
    /**
     * @var EntityManagerInterface
     */
    private $entity_manager;

    /**
     * @var ConfigurationRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entity_manager, ConfigurationRepository $repository)
    {
        $this->entity_manager = $entity_manager;
        $this->repository = $repository;
    }

    public function get($slug, $default = null)
    {
        $configuration = $this->repository->get($slug);
        if (null === $configuration) {
            return $default;
        }

        return $configuration->getValue();
    }

    public function set($slug, $value)
    {
        $configuration = $this->repository->get($slug);
        if (null === $configuration) {
            throw new \RuntimeException(sprintf(
                'Impossible to retrieve %s key configuration',
                $slug
            ));
        }

        $configuration->setValue($value);
        $this->entity_manager->persist($configuration);
        $this->entity_manager->flush();
    }
}