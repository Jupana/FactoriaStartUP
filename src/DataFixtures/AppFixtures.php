<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\Profil;
use App\Entity\Sector;
use App\Entity\ProfileUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture 
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadProjects($manager);
        
        //WE LOAD SECTORS and PROFILES ONLY ONCE
        //$this->loadSectors($manager);
        //$this->loadProfils($manager);
        
        $this->loadProfilUser($manager);
       
    }

    private function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('liviu');
        $user->setName('Liviu Vasile');
        $user->setEmail('liviu@liviu.com');
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                'liviu123'
            )
        );
        $user->setSurname1('Todoran');
        $user->setSurname2('Gologan');
        $user->setSex('Hombre');
        $user->setStreetType('Calle');
        $user->setStreetName('Vilar de Donas');
        $user->setStreetNumber('13');
        $user->setBlock('13');
        $user->setApartment('2D');
        $user->setCity('Madrid');
        $user->setPostalCode('28050');
        $user->setProvince('Madrid');
        $user->setCountry('España');
        $user->setTeamSearch('0');
        $user->setProyectSearch('1');
        $user->setPhoneNumber('999 999 999');
        $user->setInscriptionDate(new \Datetime(2019-03-12));

        $this->addReference('liviu',$user);

        $manager->persist($user);
        $manager->flush();
    }

    
    private function loadProjects(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $project = new Project();
            $project ->setProjectName('Project de Prueba');
            $project ->setProjectDescription('Some text '.rand(0,100));
            $project ->setProjectDate(new \Datetime(2019-03-12));

            $project->setUser($this->getReference('liviu'));
      
            $manager->persist($project);
        }
        $manager->flush();
    }
    

    //This function is comment on LOAD , so we will load the SECTORS only once
    private function loadSectors(ObjectManager $manager)
    { 
        $sector = new Sector();
        $sector ->setName('Educación');
        $this->addReference(1,$sector);
        $manager->persist($sector);
        
        $sector = new Sector();
        $sector ->setName('Investigación y ciencia'); 
        $this->addReference(2,$sector);
        $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Gestión y administración'); 
               $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Sanidad'); 
               $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Servicios');
               $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Ocio y entretenimiento');
               $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Distribución y vent'); 
               $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Sector inmobiliario'); 
               $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Finanzas'); 
               $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Turismo'); 
               $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Otras Aportaciones'); 
               $manager->persist($sector);       
        
        $manager->flush();
    }

    //This function is comment on LOAD , so we will load the profile only once
    private function loadProfils(ObjectManager $manager)
    { 
        $profil = new Profil();
        $profil ->setName('Marketing');
        $this->addReference(3,$profil);
        $manager->persist($profil);
     
        $profil = new Profil();
        $profil ->setName('Diseño');
        $this->addReference(4,$profil);
        $manager->persist($profil);
       
        $profil = new Profil();
        $profil ->setName('Programación'); 
        $manager->persist($profil);
      
        $profil = new Profil();
        $profil ->setName('Legal'); 
        $manager->persist($profil);

        $profil = new Profil();
        $profil ->setName('Comercial'); 
        $manager->persist($profil);

        $profil = new Profil();
        $profil ->setName('Financiero'); 
        $manager->persist($profil);

        $profil = new Profil();
        $profil ->setName('Espacio Físico'); 
        $manager->persist($profil);

        $profil = new Profil();
        $profil ->setName('Financiación'); 
        $manager->persist($profil);

        $manager->flush();
    }


    // LIVIU + NICO Don't forget to add Reference to Profil and Sector if you want to load orfile User again
    private function loadProfilUser(ObjectManager $manager)
    { 
        $ProfileUser = new ProfileUser();
        $ProfileUser -> setUser($this->getReference('liviu'));
        $ProfileUser -> setProfil($this->getReference(3));
        $ProfileUser -> setSector($this->getReference(1));
        $ProfileUser->setDescription('Primer Proyecto');
        $ProfileUser->setProfileDate(new \Datetime(2019-03-15));
        $manager->persist($ProfileUser);
        
        $ProfileUser = new ProfileUser();
        $ProfileUser -> setUser($this->getReference('liviu'));
        $ProfileUser -> setProfil($this->getReference(4));        
        $ProfileUser -> setSector($this->getReference(2));
        $ProfileUser->setDescription('Segundo Proyecto');
        $ProfileUser->setProfileDate(new \Datetime(2019-03-15));
                   
        $manager->persist($ProfileUser);
        
       
        $manager->flush();
    }
}