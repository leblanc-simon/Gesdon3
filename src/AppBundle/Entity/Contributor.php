<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contributor
 * 
 * @ORM\Table(name="contributor", indexes={})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContributorRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Contributor
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
     * @ORM\Column(length=255, type="string", nullable=true)
     * @Assert\Length(max=255, min=0)
     * @Assert\Type(type="string")
     */
    protected $firstname;

    /**
     * @var string
     * @ORM\Column(length=255, type="string", nullable=true)
     * @Assert\Length(max=255, min=0)
     * @Assert\Type(type="string")
     */
    protected $lastname;

    /**
     * @var string
     * @ORM\Column(length=255, type="string", nullable=true)
     * @Assert\Length(max=255, min=0)
     * @Assert\Type(type="string")
     */
    protected $company;

    /**
     * @var string
     * @ORM\Column(length=255, unique=true, type="string")
     * @Assert\Length(max=255, min=0)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $email;

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
     * @var ArrayCollection
     * @ORM\OneToMany(mappedBy="contributor", targetEntity="AppBundle\Entity\Donation", cascade={"persist"})
     */
    protected $donations;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(mappedBy="contributor", targetEntity="AppBundle\Entity\Address", cascade={"persist"})
     */
    protected $addresses;

    /**
     * Constructor of the Contributor class
     */
    public function __construct()
    {
        $this->donations = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }

    /**
     * String version of the object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getCompany() ?: $this->getLastname().' '.$this->getFirstname();
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
     * Get the value of firstname
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }


    /**
     * Get the value of lastname
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }


    /**
     * Get the value of company
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }


    /**
     * Get the value of email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Get the value of donations
     * @return Donation[]
     */
    public function getDonations()
    {
        return $this->donations;
    }


    /**
     * Get the value of addresses
     * @return Address[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @return Address
     */
    public function getSingleAddress()
    {
        if ($this->addresses->count() === 0) {
            return new Address();
        }

        return $this->addresses->last();
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
     * Set the value of firstname
     * @param string $firstname
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }


    /**
     * Set the value of lastname
     * @param string $lastname
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }


    /**
     * Set the value of company
     * @param string $company
     * @return self
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }


    /**
     * Set the value of email
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * Set the value of donations
     * @param  ArrayCollection     $donations
     * @return self
     */
    public function setDonations(ArrayCollection $donations)
    {
        $this->donations = $donations;
        return $this;
    }


    /**
     * Add a Donation into Contributor
     * @param  Donation     $donation
     * @return self
     */
    public function addDonation(Donation $donation)
    {
        if ($this->donations->contains($donation) === false) {
            $this->donations->add($donation);
            $donation->setContributor($this);
        }
        return $this;
    }


    /**
     * Remove a Donation into Contributor
     * @param  Donation     $donation
     * @return self
     */
    public function removeDonation(Donation $donation)
    {
        if ($this->donations->contains($donation) === true) {
            $this->donations->removeElement($donation);
            $donation->setContributor(null);
        }
        return $this;
    }


    /**
     * Set the value of addresses
     * @param  ArrayCollection     $addresses
     * @return self
     */
    public function setAddresses(ArrayCollection $addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }

    public function setSingleAddress(Address $address)
    {
        return $this->addAddress($address);
    }


    /**
     * Add a Address into Contributor
     * @param  Address     $address
     * @return self
     */
    public function addAddress(Address $address)
    {
        if ($this->addresses->contains($address) === false) {
            $this->addresses->add($address);
            $address->setContributor($this);
        }
        return $this;
    }


    /**
     * Remove a Address into Contributor
     * @param  Address     $address
     * @return self
     */
    public function removeAddress(Address $address)
    {
        if ($this->addresses->contains($address) === true) {
            $this->addresses->removeElement($address);
            $address->setContributor(null);
        }
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