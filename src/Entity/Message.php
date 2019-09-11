<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 *  @ORM\Table(name="fsu_message")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @ORM\GeneratedValue()
     */
    private $conversation_id;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="message")
     */
    private $user_sender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="message")
     */
    private $user_recipient;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InterestProfile", inversedBy="message")
     */
    private $interest_profil;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InterestProject", inversedBy="message")
     */
    private $interest_project;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Notification", mappedBy="message")
     */
    private $notification;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;
   

    public function getId(): ?int
    {
        return $this->id;
    }

     /**
     * Get the value of user_sender
     */ 
    public function getUserSender()
    {
        return $this->user_sender;
    }

    /**
     * Set the value of user_sender
     *
     * @return  self
     */ 
    public function setUserSender(User $user_sender):self
    {
        $this->user_sender = $user_sender;

        return $this;
    }

      /**
     * Get the value of user_recipient
     */ 
    public function getUserRecipient()
    {
        return $this->user_recipient;
    }

    /**
     * Set the value of user_recipient
     *
     * @return  self
     */ 
    public function setUserRecipient(User $user_recipient):self
    {
        $this->user_recipient = $user_recipient;

        return $this;
    }

      /**
     * Get the value of interest_profil
     */ 
    public function getInterestProfil()
    {
        return $this->interest_profil;
    }

    /**
     * Set the value of interest_profil
     *
     * @return  self
     */ 
    public function setInterestProfil(InterestProfile $interest_profil): self
    {
        $this->interest_profil = $interest_profil;

        return $this;
    }

    /**
     * Get the value of interest_project
     */ 
    public function getInterestProject()
    {
        return $this->interest_project;
    }

    /**
     * Set the value of interest_project
     *
     * @return  self
     */ 
    public function setInterestProject(InterestProject $interest_project):self
    {
        $this->interest_project = $interest_project;

        return $this;
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
   

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }
    

    /**
     * Get the value of text
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */ 
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of conversation_id
     */ 
    public function getConversationId()
    {
        return $this->conversation_id;
    }

    /**
     * Set the value of conversation_id
     *
     * @return  self
     */ 
    public function setConversationId(string $conversation_id)
    {
        $this->conversation_id = $conversation_id;

        return $this;
    }

    /**
     * Get the value of notification
     */ 
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Set the value of notification
     *
     * @return  self
     */ 
    public function setNotification($notification)
    {
        $this->notification = $notification;

        return $this;
    }
}
