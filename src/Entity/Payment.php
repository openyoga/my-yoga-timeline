<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 * @ORM\Table(name="payments")
 */
class Payment
{
    const NUM_ITEMS = 10;

    const CURRENCY = 'EUR';

    public function __construct() {
        $this->receiptDate = new \DateTime();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    public function getId() { return $this->id; }

    /**
     * @ORM\ManyToOne(targetEntity="Participant", inversedBy="payments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $participant;
    public function getParticipant()             { return $this->participant;                }
    public function setParticipant($participant) {        $this->participant = $participant; }

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Assert\DateTime
     */
    private $receiptDate;
    public function getReceiptDate(): \DateTime { 
        return $this->receiptDate;
    }
    public function setReceiptDate(\DateTime $receiptDate) {
        $this->receiptDate = $receiptDate;
    }   

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2, nullable=false)
     * @Assert\NotBlank
     */
    private $amount;
    public function getAmount()        { return $this->amount;           }
    public function setAmount($amount) {        $this->amount = $amount; }

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $comment;
    public function getComment()         { return $this->comment;            }
    public function setComment($comment) {        $this->comment = $comment; }

}
