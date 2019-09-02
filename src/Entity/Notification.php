<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 * @ORM\Table(name="fsu_notification")
 */
class Notification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $entity;

    /**
     * @ORM\Column(type="boolean")
     */
    private $seen;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InterestProfile", inversedBy="notifications")
     * @ORM\JoinColumn(nullable=true)
     */
    private $interestProfile;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InterestProject", inversedBy="notifications")
     * @ORM\JoinColumn(nullable=true)
     */
    private $interestProject;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getEntity(): ?int
    {
        return $this->entity;
    }

    public function setEntity(int $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    public function getSeen(): ?bool
    {
        return $this->seen;
    }

    public function setSeen(bool $seen): self
    {
        $this->seen = $seen;

        return $this;
    }

    public function getInterestProfile()
    {
        return $this->interestProfile;
    }

    public function setInterestProfile(InterestProfile $interestProfile): self
    {
        $this->interestProfile = $interestProfile;

        return $this;
    }

    public function getInterestProject()
    {
        return $this->interestProject;
    }

    public function setInterestProject(InterestProject $interestProject): self
    {
        $this->interestProject = $interestProject;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }
}
