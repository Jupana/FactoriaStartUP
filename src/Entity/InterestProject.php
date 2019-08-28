<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InterestProjectRepository")
 * @ORM\Table(name="fsu_interest_project")
 */
class InterestProject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="interest_user")
     */
    private $interest_user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="interest_project")
     */
    private $interest_project;

     /**      
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="interest_project_owner")
     */
    private $interest_project_owner;

    /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Sector", inversedBy="interest_sector")
     * 
     */
    private $interest_sector;

    /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Profil", inversedBy="interest_profil")
     * 
     */
    private $interest_profil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interest_deal;

    /**
     * @ORM\Column(type="string", length=225, nullable=true)
     */
    private $interest_percent;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $interest_description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $interest_status_contribute;


    /**
     * @ORM\Column(type="boolean")
     */
    private $interest_status_owner;



    /**
     * @ORM\Column(type="datetime")
     */
    private $interest_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInterestIdUser(): ?User
    {
        return $this->interest_user;
    }

    public function setInterestIdUser(User $interest_user): self
    {
        $this->interest_user = $interest_user;

        return $this;
    }

    public function getInterestProjectOwnerID(): ?User
    {
        return $this->interest_project_owner;
    }

    public function setInterestProjectOwnerID(User $interest_project_owner): self
    {
        $this->interest_project_owner = $interest_project_owner;

        return $this;
    }

    public function getInterestIdProject(): ?Project
    {
        return $this->interest_project;
    }

    public function setInterestIdProject(Project $interest_project): self
    {
        $this->interest_project = $interest_project;

        return $this;
    }

    public function getInterestProfil()
    {
        return $this->interest_profil;
    }

    public function setInterestProfil(Profil $interest_profil): self
    {
        $this->interest_profil = $interest_profil;

        return $this;
    }

    public function getInterestSector(): ?Sector
    {
        return $this->interest_sector;
    }

    public function setInterestSector(Sector $interest_sector): self
    {
        $this->interest_sector = $interest_sector;

        return $this;
    }

    public function getInterestDeal(): ?string
    {
        return $this->interest_deal;
    }

    public function setInterestDeal(?string $interest_deal): self
    {
        $this->interest_deal = $interest_deal;

        return $this;
    }

    public function getInterestPercent(): ?string
    {
        return $this->interest_percent;
    }

    public function setInterestPercent(?string $interest_percent): self
    {
        $this->interest_percent = $interest_percent;

        return $this;
    }

    public function getInterestDescription(): ?string
    {
        return $this->interest_description;
    }

    public function setInterestDescription(?string $interest_description): self
    {
        $this->interest_description = $interest_description;

        return $this;
    }
    
    public function getInterestStatusContribute(): ?bool
    {
        return $this->interest_status_contribute;
    }

    public function setInterestStatusContribute(bool $interest_status_contribute): self
    {
        $this->interest_status_contribute = $interest_status_contribute;

        return $this;
    }

    public function getInterestStatusOwner(): ?bool
    {
        return $this->interest_status_owner;
    }

    public function setInterestStatusOwner(bool $interest_status_owner): self
    {
        $this->interest_status_owner = $interest_status_owner;

        return $this;
    }

    public function getInterestDate(): ?\DateTimeInterface
    {
        return $this->interest_date;
    }

    public function setInterestDate(\DateTimeInterface $interest_date): self
    {
        $this->interest_date = $interest_date;

        return $this;
    }
}
