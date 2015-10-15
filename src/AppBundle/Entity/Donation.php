<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Donation
 * 
 * @ORM\Table(name="donation", uniqueConstraints={}, indexes={@ORM\Index(name="fk_donation_contributor1_idx", columns={"contributor_id"}), @ORM\Index(name="fk_donation_receipt1_idx", columns={"receipt_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DonationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Donation
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(inversedBy="donations", targetEntity="AppBundle\Entity\Contributor", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", name="contributor_id")
     */
    protected $contributor;

    /**
     * @ORM\ManyToOne(inversedBy="donations", targetEntity="AppBundle\Entity\Receipt", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", name="receipt_id")
     */
    protected $receipt;

    /**
     * @var string
     * @ORM\Column(length=255, type="string")
     * @Assert\Length(max=255, min=0)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $uuid;

    /**
     * @var float
     * @ORM\Column(type="float", options={"unsigned"=true})
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     * @Assert\Type(type="numeric")
     */
    protected $amount;

    /**
     * @var string
     * @ORM\Column(length=45, type="string")
     * @Assert\Length(max=45, min=0)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    protected $via;

    /**
     * @var float
     * @ORM\Column(type="float", options={"unsigned"=true})
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     * @Assert\Type(type="numeric")
     */
    protected $fee;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     */
    protected $converted;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
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
     * Constructor of the Donation class
     */
    public function __construct()
    {
        $this->contributor = new Contributor();
        $this->fee = 0;
        $this->converted = false;
        $this->created_at = new \DateTime();
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
     * Get the value of receipt
     * @return Receipt
     */
    public function getReceipt()
    {
        return $this->receipt;
    }


    /**
     * Get the value of uuid
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
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
     * Get the value of via
     * @return string
     */
    public function getVia()
    {
        return $this->via;
    }


    /**
     * Get the value of fee
     * @return float
     */
    public function getFee()
    {
        return $this->fee;
    }


    /**
     * Get the value of converted
     * @return bool
     */
    public function isConverted()
    {
        return $this->converted;
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
     * Set the value of receipt
     * @param Receipt $receipt
     * @return self
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
        return $this;
    }


    /**
     * Set the value of uuid
     * @param string $uuid
     * @return self
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
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
     * Set the value of fee
     * @param float $fee
     * @return self
     */
    public function setFee($fee)
    {
        $this->fee = $fee;
        return $this;
    }


    /**
     * Set the value of converted
     * @param bool $converted
     * @return self
     */
    public function setConverted($converted)
    {
        $this->converted = $converted;
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