<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileUserRepository")
 * @ORM\Table(name="fsu_profiles_users")
 */
class ProfileUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="profiles")
     * @ORM\JoinColumn()
    */
    private $user;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profil", inversedBy="profiles_profil_name")
     * @ORM\JoinColumn() 
     * @ORM\Column(name="profiles_profil_name")
    */
    private $profil;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sector", inversedBy="profiles_sector_name")
     * @ORM\JoinColumn() 
     * @ORM\Column(name="profiles_sector_name")
     * 
    */
    private $sector;

    /**
     * @ORM\Column(type="string", nullable=true,name="profiles_profesional_description")    
     */
    private $description;

      /**
     * @ORM\Column(type="datetime", nullable=false ,name="profiles_date")
     */
    private $profile_date;

   


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProfileDate(): ?\DateTimeInterface
    {
        return $this->profile_date;
    }

    public function setProfileDate(?\DateTimeInterface $profile_date): self
    {
        $this->profile_date = $profile_date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

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

}
