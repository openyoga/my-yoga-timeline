<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkshopParticipantRepository")
 * @UniqueEntity(fields={"workshop", "participant"}, errorPath="participant", message="This participant is already registered for the workshop.")
 * @ORM\Table(name="workshops_participants", 
 *    uniqueConstraints={
 *        @UniqueConstraint(name="unique_workshop_participant", columns={"workshop_id", "participant_id"})
 *    })
 */
class WorkshopParticipant
{
    const NUM_ITEMS = 10;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    public function getId() { return $this->id; }

    /**
     * @ORM\ManyToOne(targetEntity="Workshop")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $workshop;
    public function getWorkshop()          { return $this->workshop;             }
    public function setWorkshop($workshop) {        $this->workshop = $workshop; }

    /**
     * @ORM\ManyToOne(targetEntity="Participant")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $participant;
    public function getParticipant()             { return $this->participant;                }
    public function setParticipant($participant) {        $this->participant = $participant; }

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     * @Assert\NotBlank
     */
    private $specialFee;
    public function getSpecialFee()            { return $this->specialFee;               }
    public function setSpecialFee($specialFee) {        $this->specialFee = $specialFee; }

    /**
     * @ORM\Column(type="string", length=1, nullable=false)
     * @Assert\Choice({"Y", "N"})
     */
    private $feePayedYn;
    public function getFeePayedYn()            { return $this->feePayedYn;               }
    public function setFeePayedYn($feePayedYn) {        $this->feePayedYn = $feePayedYn; }

    /**
     * @ORM\Column(type="string", length=1, nullable=false)
     * @Assert\Choice({"Y", "N"})
     */
    private $attendingYn;
    public function getAttendingYn()             { return $this->attendingYn;                }
    public function setAttendingYn($attendingYn) {        $this->attendingYn = $attendingYn; }

}
