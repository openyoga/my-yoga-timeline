<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @ORM\Table(name="locations")
 */
class Location
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
    private $name;
    public function getName()      { return $this->name;         }
    public function setName($name) {        $this->name = $name; }

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $street;
    public function getStreet()        { return $this->street;           }
    public function setStreet($street) {        $this->street = $street; }

    /**
     * @ORM\Column(name="zip_code", type="string", length=20, nullable=true)
     */
    private $zipCode;
    public function getZipCode()         { return $this->zipCode;            }
    public function setZipCode($zipCode) {        $this->zipCode = $zipCode; }

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    private $city;
    public function getCity()      { return $this->city;           }
    public function setCity($city) {        $this->city = $city; }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="location")
     */
    private $events;

    /**
     * @return Collection|Event[]
     */
    public function getEvents() {
        return $this->events;
    }

}
