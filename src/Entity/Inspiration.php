<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InspirationRepository")
 * @ORM\Table(name="inspirations")
 */
class Inspiration
{
    const NUM_ITEMS = 10;

    public function __construct() {
        $this->events = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    public function getId() { return $this->id; }

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank
     */
    private $author;
    public function getAuthor()        { return $this->author;           }
    public function setAuthor($author) {        $this->author = $author; }

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    private $title;
    public function getTitle()       { return $this->title;          }
    public function setTitle($title) {        $this->title = $title; }

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $reference;
    public function getReference()           { return $this->reference;              }
    public function setReference($reference) {        $this->reference = $reference; }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="inspiration")
     */
    private $events;

    /**
     * @return Collection|Event[]
     */
    public function getEvents() {
        return $this->events;
    }

}
