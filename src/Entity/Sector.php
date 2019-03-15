<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectorRepository")
 * @ORM\Table(name="fsu_sectores")
 */
class Sector
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true,name="sector_name")
     */
    private $name;

      /**
     * @ORM\OneToMany(targetEntity="App\Entity\Profil", mappedBy="sector") 
     */
    private $profiles;
    

    public function __construct()
    {
        $this->profiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Profil[]
     */
    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

 
}
