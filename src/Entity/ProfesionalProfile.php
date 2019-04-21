<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfesionalProfileRepository")
 * @ORM\Table(name="fsu_profesional_profile")
 */
class ProfesionalProfile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5500, nullable=true, name="profesional_description")
     */
    private $profesionalDescription;

    /**
     * @ORM\Column(type="boolean", nullable=true, name="profesional_search_project")
     */
    private $profesionalSearchProject;

    /**
     * @ORM\Column(type="integer", name="profesional_id_user")
     */
    private $profesionalIdUser;

    /**
     * @ORM\Column(type="datetime", name="profesional_date")
     */
    private $profesionalDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfesionalDescription(): ?string
    {
        return $this->profesionalDescription;
    }

    public function setProfesionalDescription(?string $profesionalDescription): self
    {
        $this->profesionalDescription = $profesionalDescription;

        return $this;
    }

    public function getProfesionalSearchProject(): ?bool
    {
        return $this->profesionalSearchProject;
    }

    public function setProfesionalSearchProject(?bool $profesionalSearchProject): self
    {
        $this->profesionalSearchProject = $profesionalSearchProject;

        return $this;
    }

    public function getProfesionalIdUser(): ?int
    {
        return $this->profesionalIdUser;
    }

    public function setProfesionalIdUser(int $profesionalIdUser): self
    {
        $this->profesionalIdUser = $profesionalIdUser;

        return $this;
    }

    public function getProfesionalDate(): ?\DateTimeInterface
    {
        return $this->profesionalDate;
    }

    public function setProfesionalDate(\DateTimeInterface $profesionalDate): self
    {
        $this->profesionalDate = $profesionalDate;

        return $this;
    }
}
