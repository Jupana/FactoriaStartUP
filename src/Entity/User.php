<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Bazinga\GeocoderBundle\Mapping\Annotations as Geocoder;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="This e-mail is already used")
 * @uniqueEntity(fields="username", message="This username is already used")
 * @ORM\Table(name="fsu_users")
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer") 
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=50, unique=true,name="user_username")
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=50)
     */
    private $username;

    /**
     * @ORM\Column(type="string",name="user_password")
     */
    private $password;

    /**
     * 
     * @Assert\Length(min=8, max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=30, unique=true,name="user_email")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_name")
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_surname_1")   
     */
    private $surname_1;
      /**
     * @ORM\Column(type="string", nullable=true,name="user_surname_2") 
     
     */
    private $surname_2;

     /**
     * @ORM\Column(type="datetime", nullable=true,name="user_birth_date")
     */
    private $birth_date;

     /**
     * @ORM\Column(type="string", nullable=true,name="user_sex")
     */
    private $sex;

     /**
     * @ORM\Column(type="string", nullable=true,name="user_street_type")
     */
    private $street_type;

     /**
     * @ORM\Column(type="string", nullable=true,name="user_street_name")
     */
    private $street_name;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_street_number")
     */
    private $street_number;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_block")
     */
    private $block;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_apartment")
     */
    private $apartment;

     /**
     * @ORM\Column(type="string", nullable=true,name="user_city")
     */
    private $city;

     /**
     * @ORM\Column(type="string", nullable=true,name="user_postal_code")
     */
    private $postal_code;

     /**
     * @ORM\Column(type="string", nullable=true,name="user_provincie")
     */
    private $province;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_country")
     */
    private $country;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_perfil_img")
     * @Assert\Image
     * @Assert\File(maxSize = "2M")
     */
    private $perfil_img;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_team_search")
     */
    private $team_search;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_proyect_search")
     */
    private $proyect_search;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_phone_number")
 */
    private $phone_number;

    /**
     * @ORM\Column(type="datetime", nullable=true,name="user_inscription_date")
    
     */
    private $inscription_date;

    /**
    * @ORM\Column(type="string", nullable=true, name="user_latitud")
    * @Geocoder\Latitude
    */
    
    private $latitud;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_longitud")
     * @Geocoder\Longitude
     */
    private $longitud;

    /**
     * @ORM\Column(type="string", nullable=true,name="user_IP")
    
     */
    private $IP;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="user") 
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProfileUser", mappedBy="user") 
     */
    private $profiles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InterestProfile", mappedBy="user", orphanRemoval=true)
     */
    private $interest_profile_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InterestProject", mappedBy="interest_user", orphanRemoval=true)
     */

    private $interest_project_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notification", mappedBy="user", orphanRemoval=true)
     */

    private $notifications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contribute", mappedBy="user", orphanRemoval=true)
     */
    private $contribute;

    


    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->profiles = new ArrayCollection();
        $this->profile_id = new ArrayCollection();
        $this->interest_profile_id = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }


    public function getRoles()
    {
        return [
            'ROLE_USER'
        ];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password) = unserialize($serialized);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
      /**
        * @param mixed $plainPassword
        */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getSurname1(): ?string
    {
        return $this->surname_1;
    }

    public function setSurname1(string $surname_1): self
    {
        $this->surname_1 = $surname_1;

        return $this;
    }

    public function getSurname2(): ?string
    {
        return $this->surname_2;
    }

    public function setSurname2(string $surname_2): self
    {
        $this->surname_2 = $surname_2;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getStreetType(): ?string
    {
        return $this->street_type;
    }

    public function setStreetType(string $street_type): self
    {
        $this->street_type = $street_type;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->street_name;
    }

    public function setStreetName(string $street_name): self
    {
        $this->street_name = $street_name;

        return $this;
    }

    public function getStreetNumber()
    {
        return $this->street_number;
    }

    public function setStreetNumber($street_number): self
    {
        $this->street_number = $street_number;

        return $this;
    }

    public function getBlock()
    {
        return $this->block;
    }

    public function setBlock($block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getApartment(): ?string
    {
        return $this->apartment;
    }

    public function setApartment(string $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPerfilImg()
    {
        return $this->perfil_img;
    }

    public function setPerfilImg($file)
    {
        $this->perfil_img = $file;

        return $this;
    }

    public function getTeamSearch(): ?string
    {
        return $this->team_search;
    }

    public function setTeamSearch(string $team_search): self
    {
        $this->team_search = $team_search;

        return $this;
    }

    public function getProyectSearch(): ?string
    {
        return $this->proyect_search;
    }

    public function setProyectSearch(string $proyect_search): self
    {
        $this->proyect_search = $proyect_search;

        return $this;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function setPhoneNumber($phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getInscriptionDate(): ?\DateTimeInterface
    {
        return $this->inscription_date;
    }

    public function setInscriptionDate(\DateTimeInterface $inscription_date): self
    {
        $this->inscription_date = $inscription_date;

        return $this;
    }

    public function getLatitud()
    {
        return $this->latitud;
    }

    public function setLatitud( $latitud): self
    {
        $this->latitud = $latitud;

        return $this;
    }

    public function getLongitud() 
    {
        return $this->longitud;
    }

    public function setLongitud($longitud): self
    {
        $this->longitud = $longitud;

        return $this;
    }

    public function getIP()
    {
        return $this->IP;
    }

    public function setIP($IP): self
    {
        $this->IP = $IP;

        return $this;
    }

    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @return Collection|InterestProfile[]
     */
    public function getInterestProfileId(): Collection
    {
        return $this->interest_profile_id;
    }

    public function addInterestProfileId(InterestProfile $interestProfileId): self
    {
        if (!$this->interest_profile_id->contains($interestProfileId)) {
            $this->interest_profile_id[] = $interestProfileId;
            $interestProfileId->setUserId($this);
        }

        return $this;
    }

    public function removeInterestProfileId(InterestProfile $interestProfileId): self
    {
        if ($this->interest_profile_id->contains($interestProfileId)) {
            $this->interest_profile_id->removeElement($interestProfileId);
            // set the owning side to null (unless already changed)
            if ($interestProfileId->getUserId() === $this) {
                $interestProfileId->setUserId(null);
            }
        }

        return $this;
    }

     /**
     * @return Collection|InterestProject[]
     */
    public function getInterestProjectId(): Collection
    {
        return $this->interest_project_id;
    }

    public function addInterestProjectId(InterestProject $interestProjectId): self
    {
        if (!$this->interest_project_id->contains($interestProjectId)) {
            $this->interest_project_id[] = $interestProjectId;
            $interestProjectId->setUserId($this);
        }

        return $this;
    }

    public function removeInterestProjectId(InterestProfile $interestProjectId): self
    {
        if ($this->interest_project_id->contains($interestProjectId)) {
            $this->interest_project_id->removeElement($interestProjectId);
            // set the owning side to null (unless already changed)
            if ($interestProjectId->getUserId() === $this) {
                $interestProjectId->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contribute[]
     */
    public function getContribute(): Collection
    {
        return $this->contribute;
    }

    public function addContribute(Contribute $contribute): self
    {
        if (!$this->contribute->contains($contribute)) {
            $this->contribute[] = $contribute;
            $contribute->setUser($this);
        }

        return $this;
    }

    public function removeContribute(Contribute $contribute): self
    {
        if ($this->contribute->contains($contribute)) {
            $this->contribute->removeElement($contribute);
            // set the owning side to null (unless already changed)
            if ($contribute->getUser() === $this) {
                $contribute->setUser(null);
            }
        }

        return $this;
    }

     /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }
}
