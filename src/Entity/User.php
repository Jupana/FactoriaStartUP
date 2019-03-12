<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="This e-mail is already used")
 * @uniqueEntity(fields="username", message="This username is already used")
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
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=50)
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=30, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     
     
     */
    private $surname_1;
      /**
     * @ORM\Column(type="string", nullable=true) 
     
     */
    private $surname_2;

     /**
     * @ORM\Column(type="datetime", nullable=true)
    
     */
    private $birth_date;

     /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $sex;

     /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $street_type;

     /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $street_name;

    /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $street_number;

    /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $block;

    /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $apartment;

     /**
     * @ORM\Column(type="string", nullable=true)
    

     */
    private $city;

     /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $postal_code;

     /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $province;

    /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $country;

    /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $perfil_img;

    /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $team_search;

    /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $proyect_search;

    /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $phone_number;

    /**
     * @ORM\Column(type="datetime", nullable=true)
    
     */
    private $instription_date;

    /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $latitud;

    /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $longitud;

    /**
     * @ORM\Column(type="string", nullable=true)
    
     */
    private $IP;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="user") 
     */
    private $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
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

    public function getPerfilImg(): ?string
    {
        return $this->perfil_img;
    }

    public function setPerfilImg(string $perfil_img): self
    {
        $this->perfil_img = $perfil_img;

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

    public function getInstriptionDate(): ?\DateTimeInterface
    {
        return $this->instription_date;
    }

    public function setInstriptionDate(\DateTimeInterface $instription_date): self
    {
        $this->instription_date = $instription_date;

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

}
