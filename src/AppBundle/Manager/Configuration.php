<?php

namespace AppBundle\Manager;

use AppBundle\Repository\ConfigurationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

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

    /**
     * @var FlashBagInterface
     */
    private $session_flashbag;

    /**
     * @param EntityManagerInterface  $entity_manager
     * @param ConfigurationRepository $repository
     * @param FlashBagInterface      $session_flashbag
     */
    public function __construct(
        EntityManagerInterface $entity_manager,
        ConfigurationRepository $repository,
        FlashBagInterface $session_flashbag
    ) {
        $this->entity_manager = $entity_manager;
        $this->repository = $repository;
        $this->session_flashbag = $session_flashbag;
    }

    /**
     * @param      $slug
     * @param null $default
     * @return null|string
     */
    public function get($slug, $default = null)
    {
        $configuration = $this->repository->get($slug);
        if (null === $configuration) {
            return $default;
        }

        return $configuration->getValue();
    }

    /**
     * @param $slug
     * @param $value
     */
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

    /**
     * @return \AppBundle\Entity\Configuration[]
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param array $configurations
     */
    public function saveAll(array $configurations)
    {
        foreach ($configurations as $configuration) {
            $this->entity_manager->persist($configuration);
        }
        $this->entity_manager->flush();

        $this->session_flashbag->add('success', 'parameters.saved');
    }
}