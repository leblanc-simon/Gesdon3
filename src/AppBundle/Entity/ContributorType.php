<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ContributorType
 * 
 * @ORM\Table(name="contributor_type")
 * @ORM\Entity
 * @UniqueEntity("slug")
 */
class ContributorType
{
    const DEFAULT_TYPE = 'personal';

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
     * @var ArrayCollection
     * @ORM\OneToMany(mappedBy="contributor_type", targetEntity="AppBundle\Entity\Contributor")
     */
    protected $contributors;

    /**
     * Constructor of the ContributorType class
     */
    public function __construct()
    {
        $this->contributors = new ArrayCollection();
    }

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
     * Get the value of contributors
     * @return Contributor[]
     */
    public function getContributors()
    {
        return $this->contributors;
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
     * Set the value of contributors
     * @param  ArrayCollection     $contributors
     * @return self
     */
    public function setContributors(ArrayCollection $contributors)
    {
        $this->contributors = $contributors;
        return $this;
    }


    /**
     * Add a Contributor into ContributorType
     * @param  Contributor     $contributor
     * @return self
     */
    public function addContributor(Contributor $contributor)
    {
        if ($this->contributors->contains($contributor) === false) {
            $this->contributors->add($contributor);
            $contributor->setContributorType($this);
        }
        return $this;
    }


    /**
     * Remove a Contributor into ContributorType
     * @param  Contributor     $contributor
     * @return self
     */
    public function removeContributor(Contributor $contributor)
    {
        if ($this->contributors->contains($contributor) === true) {
            $this->contributors->removeElement($contributor);
            $contributor->setContributorType(null);
        }
        return $this;
    }
}