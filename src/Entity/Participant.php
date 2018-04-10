<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantRepository")
 * @ORM\Table(name="participants")
 */
class Participant
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
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $academicTitle;
    public function getAcademicTitle()               { return $this->academicTitle;                  }
    public function setAcademicTitle($academicTitle) {        $this->academicTitle = $academicTitle; }

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank
     */
    private $firstName;
    public function getFirstName()           { return $this->firstName;              }
    public function setFirstName($firstName) {        $this->firstName = $firstName; }

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $lastName;
    public function getLastName()          { return $this->lastName;             }
    public function setLastName($lastName) {        $this->lastName = $lastName; }

    /**
     * @ORM\Column(type="string", length=100, nullable=false, unique=true)
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;
    public function getEmail()       { return $this->email;          }
    public function setEmail($email) {        $this->email = $email; }

    /**
     * @ORM\Column(type="string", length=1, nullable=false)
     * @Assert\Choice({"Y", "N"})
     */
    private $infoMailsYn;
    public function getInfoMailsYn()             { return $this->infoMailsYn;                }
    public function setInfoMailsYn($infoMailsYn) {        $this->infoMailsYn = $infoMailsYn; }

    /**
     * @ORM\Column(type="string", length=1, nullable=false)
     * @Assert\Choice({"Y", "N"})
     */
    private $activeYn;
    public function getActiveYn()          { return $this->activeYn;             }
    public function setActiveYn($activeYn) {        $this->activeYn = $activeYn; }

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $comments;
    public function getComments()          { return $this->comments;             }
    public function setComments($comments) {        $this->comments = $comments; }

}
