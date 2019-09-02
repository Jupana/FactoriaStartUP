<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InterestProfileRepository")
 * @ORM\Table(name="fsu_interest_profile")
 */
class InterestProfile
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
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="user_profile_owner")
     */
    
    private $user_profile_owner;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profil", inversedBy="interest_profil")
     * 
     */

    private $interest_profile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="interest_project")
     * 
     */
    
    private $interest_project;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $interest_description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $interest_status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $interest_date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Message", inversedBy="interest_profil")
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserProfileOwner()
    {
        return $this->user_profile_owner;
    }

    public function setUserProfileOwner(User $user_profile_owner) :self
    {
        $this->user_profile_owner = $user_profile_owner;

        return $this;
    }

    public function getInterestProfile()
    {
        return $this->interest_profile;
    }

    public function setInterestProfile(Profil $interest_profile) :self
    {
        $this->interest_profile = $interest_profile;

        return $this;
    }

    public function getInterestProject()
    {
        return $this->interest_project;
    }

    public function setInterestProject(Project $interest_project) :self
    {
        $this->interest_project = $interest_project;

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

    public function getInterestStatus(): ?bool
    {
        return $this->interest_status;
    }

    public function setInterestStatus(?bool $interest_status): self
    {
        $this->interest_status = $interest_status;

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

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        return $this;
    }
}
