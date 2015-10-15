<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Donation;

/**
 * Receipt
 * 
 * @ORM\Table(name="receipt", uniqueConstraints={@ORM\UniqueConstraint(name="legal_number_UNIQUE", columns={"legal_number"})}, indexes={})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Receipt
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    protected $id;

    /**
     * @var int
     * @ORM\Column(unique=true, type="integer", options={"unsigned"=true})
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     * @Assert\Type(type="numeric")
     */
    protected $legal_number;

    /**
     * @var string
     * @ORM\Column(length=255, type="string")
     * @Assert\Length(max=255, min=0)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Type(type="string")
     */
    protected $email;

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
     * @var float
     * @ORM\Column(type="float", options={"unsigned"=true})
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     * @Assert\Type(type="numeric")
     */
    protected $amount;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     * @Assert\DateTime()
     */
    protected $begin_date;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     * @Assert\DateTime()
     */
    protected $end_date;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     */
    protected $recurring;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     */
    protected $sended;

    /**
     * @var string
     * @ORM\Column(length=45, type="string")
     * @Assert\Length(max=45, min=0)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $via;

    /**
     * @var string
     * @ORM\Column(length=255, type="string", nullable=true)
     * @Assert\Length(max=255, min=0)
     * @Assert\Type(type="string")
     */
    protected $filename;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     * @Assert\DateTime()
     */
    protected $created_at;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $sended_at;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(mappedBy="receipt", targetEntity="AppBundle\Entity\Donation", cascade={"persist"})
     */
    protected $donations;

    /**
     * Constructor of the Receipt class
     */
    public function __construct()
    {
        $this->amount = 0;
        $this->recurring = false;
        $this->sended = false;
        $this->donations = new ArrayCollection();
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
     * Get the value of legal_number
     * @return int
     */
    public function getLegalNumber()
    {
        return $this->legal_number;
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
     * Get the value of amount
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }


    /**
     * Get the value of begin_date
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->begin_date;
    }


    /**
     * Get the value of end_date
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }


    /**
     * Get the value of recurring
     * @return bool
     */
    public function isRecurring()
    {
        return $this->recurring;
    }


    /**
     * Get the value of sended
     * @return bool
     */
    public function isSended()
    {
        return $this->sended;
    }


    /**
     * Get the value of via
     * @return string
     */
    public function getVia()
    {
        return $this->via;
    }


    /**
     * Get the value of filename
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
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
     * Get the value of sended_at
     * @return \DateTime
     */
    public function getSendedAt()
    {
        return $this->sended_at;
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
     * Set the value of legal_number
     * @param int $legal_number
     * @return self
     */
    public function setLegalNumber($legal_number)
    {
        $this->legal_number = $legal_number;
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
     * Set the value of amount
     * @param float $amount
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }


    /**
     * Set the value of begin_date
     * @param \DateTime $begin_date
     * @return self
     */
    public function setBeginDate(\DateTime $begin_date)
    {
        $this->begin_date = $begin_date;
        return $this;
    }


    /**
     * Set the value of end_date
     * @param \DateTime $end_date
     * @return self
     */
    public function setEndDate(\DateTime $end_date)
    {
        $this->end_date = $end_date;
        return $this;
    }


    /**
     * Set the value of recurring
     * @param bool $recurring
     * @return self
     */
    public function setRecurring($recurring)
    {
        $this->recurring = $recurring;
        return $this;
    }


    /**
     * Set the value of sended
     * @param bool $sended
     * @return self
     */
    public function setSended($sended)
    {
        $this->sended = $sended;
        return $this;
    }


    /**
     * Set the value of via
     * @param string $via
     * @return self
     */
    public function setVia($via)
    {
        $this->via = $via;
        return $this;
    }


    /**
     * Set the value of filename
     * @param string $filename
     * @return self
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
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
     * Set the value of sended_at
     * @param \DateTime $sended_at
     * @return self
     */
    public function setSendedAt(\DateTime $sended_at)
    {
        $this->sended_at = $sended_at;
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
     * Add a Donation into Receipt
     * @param  Donation     $donation
     * @return self
     */
    public function addDonation(Donation $donation)
    {
        if ($this->donations->contains($donation) === false) {
            $this->donations->add($donation);
            $donation->setReceipt($this);
        }
        return $this;
    }


    /**
     * Remove a Donation into Receipt
     * @param  Donation     $donation
     * @return self
     */
    public function removeDonation(Donation $donation)
    {
        if ($this->donations->contains($donation) === true) {
            $this->donations->removeElement($donation);
            $donation->setReceipt(null);
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