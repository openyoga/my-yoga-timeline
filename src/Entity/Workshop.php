<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkshopRepository")
 * @ORM\Table(name="workshops")
 */
class Workshop
{
    const NUM_ITEMS = 10;

    public function __construct() {
        $this->plannedDate = new \DateTime();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    public function getId() { return $this->id; }

    /**
     * @ORM\ManyToOne(targetEntity="YogaStyle", inversedBy="workshops")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $yogaStyle;
    public function getYogaStyle()           { return $this->yogaStyle;              }
    public function setYogaStyle($yogaStyle) {        $this->yogaStyle = $yogaStyle; }

    /**
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="workshops")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $location;
    public function getLocation()                   { return $this->location;             }
    public function setLocation(Location $location) {        $this->location = $location; }

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2, nullable=false)
     * @Assert\NotBlank
     */
    private $locationFee;
    public function getLocationFee()             { return $this->locationFee;                }
    public function setLocationFee($locationFee) {        $this->locationFee = $locationFee; }

    /**
     * @ORM\ManyToOne(targetEntity="Inspiration", inversedBy="workshops")
     * @ORM\JoinColumn(nullable=true)
     */
    private $inspiration;
    public function getInspiration()             { return $this->inspiration;                }
    public function setInspiration($inspiration) {        $this->inspiration = $inspiration; }

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Assert\DateTime
     */
    private $plannedDate;
    public function getPlannedDate(): \DateTime { 
        return $this->plannedDate;
    }
    public function setPlannedDate(\DateTime $plannedDate) {
        $this->plannedDate = $plannedDate;
    }   

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank
     */
    private $duration;
    public function getDuration()          { return $this->duration;             }
    public function setDuration($duration) {        $this->duration = $duration; }

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=false)
     * @Assert\NotBlank
     */
    private $fee;
    public function getFee()     { return $this->fee;        }
    public function setFee($fee) {        $this->fee = $fee; }

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $comments;
    public function getComments()          { return $this->comments;             }
    public function setComments($comments) {        $this->comments = $comments; }

}
