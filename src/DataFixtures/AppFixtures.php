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
        $this->loadSectors($manager);
        $this->loadProfils($manager);
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

    private function loadSectors(ObjectManager $manager)
    { 
        $sector = new Sector();
        $sector ->setName('Educación'); 
        $this->addReference('Educación',$sector);      
        $manager->persist($sector);
        

        $sector = new Sector();
        $sector ->setName('Investigación y ciencia'); 
        $this->addReference('Investigación y ciencia',$sector);      
        $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Gestión y administración'); 
        $this->addReference('Gestión y administración',$sector);      
        $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Sanidad'); 
        $this->addReference('Sanidad',$sector);      
        $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Servicios'); 
        $this->addReference('Servicios',$sector);      
        $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Ocio y entretenimiento'); 
        $this->addReference('Ocio y entretenimiento',$sector);      
        $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Distribución y vent'); 
        $this->addReference('Distribución y vent',$sector);      
        $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Sector inmobiliario'); 
        $this->addReference('Sector inmobiliario',$sector);      
        $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Finanzas'); 
        $this->addReference('Finanzas',$sector);      
        $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Turismo'); 
        $this->addReference('Turismo',$sector);      
        $manager->persist($sector);

        $sector = new Sector();
        $sector ->setName('Otras Aportaciones'); 
        $this->addReference('Otras Aportaciones',$sector);      
        $manager->persist($sector);       
        $manager->flush();
    }

    private function loadProfils(ObjectManager $manager)
    { 
        $profil = new Profil();
        $profil ->setName('Contable');  
        $this->addReference('Contable',$profil);      
        $profil->setSector($this->getReference('Financiero'));
        $manager->persist($profil);
     
        $profil = new Profil();
        $profil ->setName('Administrativo financiero');
        $this->addReference('Administrativo financiero',$profil);   
        $profil->setSector($this->getReference('Financiero'));     
        $manager->persist($profil);
       
        $profil = new Profil();
        $profil ->setName('Comercial'); 
        $this->addReference('Comercial',$profil); 
        $profil->setSector($this->getReference('Ventas'));      
        $manager->persist($profil);
      
        $profil = new Profil();
        $profil ->setName('Analista Web'); 
        $this->addReference('Analista Web',$profil);  
        $profil->setSector($this->getReference('Marketing'));     
        $manager->persist($profil);

        $profil = new Profil();
        $profil ->setName('Director marketing'); 
        $this->addReference('Director marketing',$profil); 
        $profil->setSector($this->getReference('Marketing'));       
        $manager->persist($profil);

       
        $manager->flush();
    }

    private function loadProfilUser(ObjectManager $manager)
    { 
        $ProfileUser = new ProfileUser();
        $ProfileUser -> setUser($this->getReference('liviu'));
        $ProfileUser -> setProfil($this->getReference('Analista Web'));
        $ProfileUser -> setSector($this->getReference('Marketing'));
        $ProfileUser->setDescription('Aqui esta la descripcion profesional sobre el perfil grabado de prueba');
        $ProfileUser->setProfileDate(new \Datetime(2019-03-15));
           
        $manager->persist($ProfileUser);

        $ProfileUser = new ProfileUser();
        $ProfileUser -> setUser($this->getReference('liviu'));
        $ProfileUser -> setProfil($this->getReference('Comercial'));
        $ProfileUser -> setSector($this->getReference('Ventas'));
        $ProfileUser->setDescription('Aqui esta la descripcion profesional sobre el perfil grabado de prueba');
        $ProfileUser->setProfileDate(new \Datetime(2019-03-15));
           
        $manager->persist($ProfileUser);
        
       
        $manager->flush();
    }


}