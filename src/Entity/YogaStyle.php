<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\YogaStyleRepository")
 * @ORM\Table(name="yoga_styles")
 */
class YogaStyle
{
    const NUM_ITEMS = 10;

    public function __construct() {
        $this->workshops = new ArrayCollection();
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
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank
     */
    private $description;
    public function getdescription()             { return $this->description;                }
    public function setdescription($description) {        $this->description = $description; }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Workshop", mappedBy="yogaStyle")
     */
    private $workshops;

    /**
     * @return Collection|Workshop[]
     */
    public function getWorkshops() {
        return $this->workshops;
    }

}
