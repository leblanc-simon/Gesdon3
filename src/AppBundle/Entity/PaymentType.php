<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * PaymentType
 * 
 * @ORM\Table(name="payment_type")
 * @ORM\Entity
 * @UniqueEntity("slug")
 */
class PaymentType
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
     * @var ArrayCollection
     * @ORM\OneToMany(mappedBy="payment_type", targetEntity="AppBundle\Entity\Donation")
     */
    protected $donations;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(mappedBy="payment_type", targetEntity="AppBundle\Entity\Receipt")
     */
    protected $receipts;

    /**
     * Constructor of the PaymentType class
     */
    public function __construct()
    {
        $this->donations = new ArrayCollection();
        $this->receipts = new ArrayCollection();
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
     * Get the value of donations
     * @return Donation[]
     */
    public function getDonations()
    {
        return $this->donations;
    }


    /**
     * Get the value of receipts
     * @return Receipt[]
     */
    public function getReceipts()
    {
        return $this->receipts;
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
     * Add a Donation into PaymentType
     * @param  Donation     $donation
     * @return self
     */
    public function addDonation(Donation $donation)
    {
        if ($this->donations->contains($donation) === false) {
            $this->donations->add($donation);
            $donation->setPaymentType($this);
        }
        return $this;
    }


    /**
     * Remove a Donation into PaymentType
     * @param  Donation     $donation
     * @return self
     */
    public function removeDonation(Donation $donation)
    {
        if ($this->donations->contains($donation) === true) {
            $this->donations->removeElement($donation);
            $donation->setPaymentType(null);
        }
        return $this;
    }


    /**
     * Set the value of receipts
     * @param  ArrayCollection     $receipts
     * @return self
     */
    public function setReceipts(ArrayCollection $receipts)
    {
        $this->receipts = $receipts;
        return $this;
    }


    /**
     * Add a Receipt into PaymentType
     * @param  Receipt     $receipt
     * @return self
     */
    public function addReceipt(Receipt $receipt)
    {
        if ($this->receipts->contains($receipt) === false) {
            $this->receipts->add($receipt);
            $receipt->setPaymentType($this);
        }
        return $this;
    }


    /**
     * Remove a Receipt into PaymentType
     * @param  Receipt     $receipt
     * @return self
     */
    public function removeReceipt(Receipt $receipt)
    {
        if ($this->receipts->contains($receipt) === true) {
            $this->receipts->removeElement($receipt);
            $receipt->setPaymentType(null);
        }
        return $this;
    }
}
