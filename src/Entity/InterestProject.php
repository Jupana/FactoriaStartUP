<?php

namespace App\Entity;

use App\Entity\Project;
use App\Entity\Profil;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="interest_user_id")
     * @ORM\Column(type="integer")
     */
    private $interest_id_user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="interest_project_id")
     * @ORM\Column(type="integer")
     */
    private $interest_id_project;

     /**     * 
     * @ORM\Column(type="integer")
     */
    private $interest_project_owner_id;

    /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Sector", inversedBy="interest_sector")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interest_sector;

    /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Profil", inversedBy="interest_profil")
     * @ORM\Column(type="string", length=255, nullable=true)
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

    public function getInterestIdUser(): ?int
    {
        return $this->interest_id_user;
    }

    public function setInterestIdUser(int $interest_id_user): self
    {
        $this->interest_id_user = $interest_id_user;

        return $this;
    }

    public function getInterestProjectOwnerID(): ?int
    {
        return $this->interest_project_owner_id;;
    }

    public function setInterestProjectOwnerID(int $interest_project_owner_id): self
    {
        $this->interest_project_owner_id = $interest_project_owner_id;

        return $this;
    }

    public function getInterestIdProject(): ?int
    {
        return $this->interest_id_project;
    }

    public function setInterestIdProject(int $interest_id_project): self
    {
        $this->interest_id_project = $interest_id_project;

        return $this;
    }

    public function getInterestProfil(): ?string
    {
        return $this->interest_profil;
    }

    public function setInterestProfil(?string $interest_profil): self
    {
        $this->interest_profil = $interest_profil;

        return $this;
    }

    public function getInterestSector(): ?string
    {
        return $this->interest_sector;
    }

    public function setInterestSector(?string $interest_sector): self
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
