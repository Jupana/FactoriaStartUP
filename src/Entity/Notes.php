<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotesRepository")
 * @ORM\Table(name="fsu_notes")
 */
class Notes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InterestProfile")
     */
    private $interest_profile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InterestProject")
     */
    private $interest_project;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $notes_date;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $notes_uniq_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project")
     */
    private $project_notes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profil")
     */
    private $profile_notes;
   

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

    public function getInterestProfile(): ?InterestProfile
    {
        return $this->interest_profile;
    }

    public function setInterestProfile(?InterestProfile $interest_profile): self
    {
        $this->interest_profile = $interest_profile;

        return $this;
    }

    public function getInterestProject(): ?InterestProject
    {
        return $this->interest_project;
    }

    public function setInterestProject(?InterestProject $interest_project): self
    {
        $this->interest_project = $interest_project;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getNotesDate(): ?\DateTimeInterface
    {
        return $this->notes_date;
    }

    public function setNotesDate(\DateTimeInterface $notes_date): self
    {
        $this->notes_date = $notes_date;

        return $this;
    }
    

    /**
     * Get the value of notes_uniq_id
     */ 
    public function getNotesUniqId()
    {
        return $this->notes_uniq_id;
    }

    /**
     * Set the value of notes_uniq_id
     *
     * @return  self
     */ 
    public function setNotesUniqId($notes_uniq_id)
    {
        $this->notes_uniq_id = $notes_uniq_id;

        return $this;
    }

    /**
     * Get the value of project_notes
     */ 
    public function getProjectNotes()
    {
        return $this->project_notes;
    }

    /**
     * Set the value of project_notes
     *
     * @return  self
     */ 
    public function setProjectNotes($project_notes)
    {
        $this->project_notes = $project_notes;

        return $this;
    }

    /**
     * Get the value of profile_notes
     */ 
    public function getProfileNotes()
    {
        return $this->profile_notes;
    }

    /**
     * Set the value of profile_notes
     *
     * @return  self
     */ 
    public function setProfileNotes($profile_notes)
    {
        $this->profile_notes = $profile_notes;

        return $this;
    }
}
