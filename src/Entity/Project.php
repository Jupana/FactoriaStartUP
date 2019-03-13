<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 * *@ORM\Table(name="fsu_projects")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="projects")
     * @ORM\JoinColumn()
    */
    private $user;

    /**
     * @ORM\Column(type="string", nullable=true)
    */
    private $project_name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $project_short_description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $project_description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $project_sector;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $project_state;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $project_clientes_users;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $project_potentialy_users;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $project_potentialy_companies;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $project_aprox_facturation1;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $project_aprox_facturation2;

     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $project_aprox_facturation3;

     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $project_competitors;

     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $project_team_number;

     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $project_team;

     /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $project_date;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectName(): ?string
    {
        return $this->project_name;
    }

    public function setProjectName(?string $project_name): self
    {
        $this->project_name = $project_name;

        return $this;
    }

    public function getProjectShortDescription(): ?string
    {
        return $this->project_short_description;
    }

    public function setProjectShortDescription(?string $project_short_description): self
    {
        $this->project_short_description = $project_short_description;

        return $this;
    }

    public function getProjectDescription(): ?string
    {
        return $this->project_description;
    }

    public function setProjectDescription(?string $project_description): self
    {
        $this->project_description = $project_description;

        return $this;
    }

    public function getProjectSector(): ?string
    {
        return $this->project_sector;
    }

    public function setProjectSector(?string $project_sector): self
    {
        $this->project_sector = $project_sector;

        return $this;
    }

    public function getProjectState(): ?string
    {
        return $this->project_state;
    }

    public function setProjectState(?string $project_state): self
    {
        $this->project_state = $project_state;

        return $this;
    }

    public function getProjectClientesUsers(): ?string
    {
        return $this->project_clientes_users;
    }

    public function setProjectClientesUsers(?string $project_clientes_users): self
    {
        $this->project_clientes_users = $project_clientes_users;

        return $this;
    }

    public function getProjectPotentialyUsers(): ?string
    {
        return $this->project_potentialy_users;
    }

    public function setProjectPotentialyUsers(?string $project_potentialy_users): self
    {
        $this->project_potentialy_users = $project_potentialy_users;

        return $this;
    }

    public function getProjectPotentialyCompanies(): ?string
    {
        return $this->project_potentialy_companies;
    }

    public function setProjectPotentialyCompanies(?string $project_potentialy_companies): self
    {
        $this->project_potentialy_companies = $project_potentialy_companies;

        return $this;
    }

    public function getProjectAproxFacturation1(): ?string
    {
        return $this->project_aprox_facturation1;
    }

    public function setProjectAproxFacturation1(?string $project_aprox_facturation1): self
    {
        $this->project_aprox_facturation1 = $project_aprox_facturation1;

        return $this;
    }

    public function getProjectAproxFacturation2(): ?string
    {
        return $this->project_aprox_facturation2;
    }

    public function setProjectAproxFacturation2(?string $project_aprox_facturation2): self
    {
        $this->project_aprox_facturation2 = $project_aprox_facturation2;

        return $this;
    }

    public function getProjectAproxFacturation3(): ?string
    {
        return $this->project_aprox_facturation3;
    }

    public function setProjectAproxFacturation3(?string $project_aprox_facturation3): self
    {
        $this->project_aprox_facturation3 = $project_aprox_facturation3;

        return $this;
    }

    public function getProjectCompetitors(): ?string
    {
        return $this->project_competitors;
    }

    public function setProjectCompetitors(?string $project_competitors): self
    {
        $this->project_competitors = $project_competitors;

        return $this;
    }

    public function getProjectTeamNumber(): ?string
    {
        return $this->project_team_number;
    }

    public function setProjectTeamNumber(?string $project_team_number): self
    {
        $this->project_team_number = $project_team_number;

        return $this;
    }

    public function getProjectTeam(): ?string
    {
        return $this->project_team;
    }

    public function setProjectTeam(?string $project_team): self
    {
        $this->project_team = $project_team;

        return $this;
    }

    public function getProjectDate(): ?\DateTimeInterface
    {
        return $this->project_date;
    }

    public function setProjectDate(?\DateTimeInterface $project_date): self
    {
        $this->project_date = $project_date;

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

  

  
}
