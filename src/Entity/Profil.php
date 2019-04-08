<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfilRepository")
 * @ORM\Table(name="fsu_profiles")
 */
class Profil
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string", nullable=true, name="profil_name")
     */
    private $name;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sector", inversedBy="profiles")
     * @ORM\JoinColumn()
    */
    private $sector;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProfileUser", mappedBy="profil") 
     */
    private $profil_records;


    public function __construct()
    {
        $this->profil_records = new ArrayCollection();
      
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

    public function getSector(): ?Sector
    {
        return $this->sector;
    }

    public function setSector(?Sector $sector): self
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * @return Collection|ProfileUser[]
     */
    public function getProfilRecords(): Collection
    {
        return $this->profil_records;
    }

    public function addProfilRecord(ProfileUser $profilRecord): self
    {
        if (!$this->profil_records->contains($profilRecord)) {
            $this->profil_records[] = $profilRecord;
            $profilRecord->setProfil($this);
        }

        return $this;
    }

    public function removeProfilRecord(ProfileUser $profilRecord): self
    {
        if ($this->profil_records->contains($profilRecord)) {
            $this->profil_records->removeElement($profilRecord);
            // set the owning side to null (unless already changed)
            if ($profilRecord->getProfil() === $this) {
                $profilRecord->setProfil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProfileUser[]
     */
    public function getSectorRecords(): Collection
    {
        return $this->sector_records;
    }

    public function addSectorRecord(ProfileUser $sectorRecord): self
    {
        if (!$this->sector_records->contains($sectorRecord)) {
            $this->sector_records[] = $sectorRecord;
            $sectorRecord->setSector($this);
        }

        return $this;
    }

    public function removeSectorRecord(ProfileUser $sectorRecord): self
    {
        if ($this->sector_records->contains($sectorRecord)) {
            $this->sector_records->removeElement($sectorRecord);
            // set the owning side to null (unless already changed)
            if ($sectorRecord->getSector() === $this) {
                $sectorRecord->setSector(null);
            }
        }

        return $this;
    }
}
