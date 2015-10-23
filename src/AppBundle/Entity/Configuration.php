<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Configuration
 * 
 * @ORM\Table(name="configuration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfigurationRepository")
 * @UniqueEntity("slug")
 */
class Configuration
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(length=45, unique=true, type="string")
     * @Assert\Length(max=45, min=0)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $slug;

    /**
     * @var string
     * @ORM\Column(length=45, type="string")
     * @Assert\Length(max=45, min=0)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $value;

    /**
     * Return the name when show the object
     * @return string
     */
    public function __toString()
    {
        return $this->getName() ?: '-';
    }

    /**
     * Get the value of id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get the value of slug
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Get the value of name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Get the value of value
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * Set the value of id
     * @param int $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * Set the value of slug
     * @param string $slug
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }


    /**
     * Set the value of name
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * Set the value of value
     * @param string $value
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
