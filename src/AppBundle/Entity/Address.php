<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Address
 * 
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AddressRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Address
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(inversedBy="addresses", targetEntity="AppBundle\Entity\Contributor", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", name="contributor_id", nullable=false)
     * @Assert\NotNull()
     */
    protected $contributor;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $street;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $additional;

    /**
     * @var string
     * @ORM\Column(length=45, type="string")
     * @Assert\Length(max=45, min=0)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $zip_code;

    /**
     * @var string
     * @ORM\Column(length=255, type="string")
     * @Assert\Length(max=255, min=0)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $city;

    /**
     * @var string
     * @ORM\Column(length=255, type="string")
     * @Assert\Length(max=255, min=0)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $country;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    protected $created_at;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    protected $updated_at;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     */
    protected $active;

    /**
     * Constructor of the Address class
     */
    public function __construct()
    {
        $this->active = true;
        $this->country = 'FR';
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
     * Get the value of contributor
     * @return Contributor
     */
    public function getContributor()
    {
        return $this->contributor;
    }


    /**
     * Get the value of street
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }


    /**
     * Get the value of additional
     * @return string
     */
    public function getAdditional()
    {
        return $this->additional;
    }


    /**
     * Get the value of zip_code
     * @return string
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }


    /**
     * Get the value of city
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }


    /**
     * Get the value of country
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }


    /**
     * Get the value of created_at
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }


    /**
     * Get the value of updated_at
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }


    /**
     * Get the value of active
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
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
     * Set the value of contributor
     * @param Contributor $contributor
     * @return self
     */
    public function setContributor($contributor)
    {
        $this->contributor = $contributor;
        return $this;
    }


    /**
     * Set the value of street
     * @param string $street
     * @return self
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }


    /**
     * Set the value of additional
     * @param string $additional
     * @return self
     */
    public function setAdditional($additional)
    {
        $this->additional = $additional;
        return $this;
    }


    /**
     * Set the value of zip_code
     * @param string $zip_code
     * @return self
     */
    public function setZipCode($zip_code)
    {
        $this->zip_code = $zip_code;
        return $this;
    }


    /**
     * Set the value of city
     * @param string $city
     * @return self
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }


    /**
     * Set the value of country
     * @param string $country
     * @return self
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }


    /**
     * Set the value of created_at
     * @param \DateTime $created_at
     * @return self
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }


    /**
     * Set the value of updated_at
     * @param \DateTime $updated_at
     * @return self
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }


    /**
     * Set the value of active
     * @param bool $active
     * @return self
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }


    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime());
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime());
        }
    }
}