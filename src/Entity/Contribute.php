<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Project;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContributeRepository")
 * @ORM\Table(name="fsu_contribute")
 */
class Contribute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="contribute")
     * @ORM\JoinColumn()      
    */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="contribute_id")
     */
    private $contribute_project;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    private $contribute_profile;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    private $contribute_description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $contribute_date;


    public function getId(): ?int
    {
        return $this->id;
    }
  
    public function getUser()
    {
        return $this->contribute_user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    
    public function getContributeIdProject(): Project
    {
        return $this->contribute_project;
    }

    public function setContributeIdProject(Project $contribute_project): self
    {        
        $this->contribute_project = $contribute_project;
        return $this;
    }

    public function getContributeProfile(): ?string
    {
        return $this->contribute_profile;
    }

    public function setContributeProfile(?string $contributeProfile): self
    {
        $this->contribute_profile = $contributeProfile;
        return $this;
    }

    
    public function getContributeDescription(): ?string
    {
        return $this->contribute_description;
    }

    public function setContributeDescription(?string $contribute_description): self
    {
        $this->contribute_description = $contribute_description;

        return $this;
    }

    public function getContributeDate(): ?\DateTimeInterface
    {
        return $this->contribute_date;
    }

    public function setContributeDate(\DateTimeInterface $contribute_date): self
    {
        $this->contribute_date = $contribute_date;

        return $this;
    }
}
