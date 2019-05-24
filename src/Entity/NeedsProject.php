<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NeedsProjectRepository")
 *  @ORM\Table(name="fsu_needs_project")
 */
class NeedsProject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="needs")
     * @ORM\JoinColumn()       
    */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="needs_project")     
     */
    private $needs_project;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    private $needs_perfil;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    private $needs_deal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $needs_percent;

    /**
     * @ORM\Column(type="string", length=3000)
     */
    private $needs_description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $needs_status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $needs_date;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNeedsIdProject()
    {
        return $this->needs_project;
    }

    public function setNeedsIdProject(Project $needs_project): self
    {
        $this->needs_project = $needs_project;
        return $this;
    }

    public function getNeedsPerfil(): ?string
    {
        return $this->needs_perfil;
    }

    public function setNeedsPerfil( $needs_perfil): self
    {
        $this->needs_perfil = $needs_perfil;

        return $this;
    }

    public function getNeedsDeal(): ?string
    {
        return $this->needs_deal;
    }

    public function setNeedsDeal(?string $needs_deal): self
    {
        $this->needs_deal = $needs_deal;

        return $this;
    }

    public function getNeedsPercent(): ?string
    {
        return $this->needs_percent;
    }

    public function setNeedsPercent(?string $needs_percent): self
    {
        $this->needs_percent = $needs_percent;

        return $this;
    }

    public function getNeedsDescription(): ?string
    {
        return $this->needs_description;
    }

    public function setNeedsDescription(string $needs_description): self
    {
        $this->needs_description = $needs_description;

        return $this;
    }

    public function getNeedsStatus(): ?string
    {
        return $this->needs_status;
    }

    public function setNeedsStatus(?string $needs_status): self
    {
        $this->needs_status = $needs_status;

        return $this;
    }

    public function getNeedsDate(): ?\DateTimeInterface
    {
        return $this->needs_date;
    }

    public function setNeedsDate(\DateTimeInterface $needs_date): self
    {
        $this->needs_date = $needs_date;

        return $this;
    }
    
}
