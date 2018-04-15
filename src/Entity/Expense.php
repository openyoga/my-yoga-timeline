<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExpenseRepository")
 * @ORM\Table(name="expenses")
 */
class Expense
{
    const NUM_ITEMS = 10;
    const CURRENCY_SYMBOL = '€';

    public function __construct() {
        $this->dateSpent = new \DateTime();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    public function getId() { return $this->id; }

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Assert\DateTime
     */
    private $dateSpent;
    public function getDateSpent(): \DateTime { 
        return $this->dateSpent;
    }
    public function setDateSpent(\DateTime $dateSpent) {
        $this->dateSpent = $dateSpent;
    }

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false)
     * @Assert\NotBlank
     */
    private $amount;
    public function getAmount()        { return $this->amount;           }
    public function setAmount($amount) {        $this->amount = $amount; }

    /**
     * @ORM\Column(type="string", length=250, nullable=false)
     * @Assert\NotBlank
     */
    private $description;
    public function getDescription()             { return $this->description;                }
    public function setDescription($description) {        $this->description = $description; }

}
