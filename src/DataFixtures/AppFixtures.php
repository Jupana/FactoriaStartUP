<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Project;
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
        $user->setInstriptionDate(new \Datetime(2019-03-12));

        $this->addReference('liviu',$user);

        $manager->persist($user);
        $manager->flush();
    }

    
    private function loadProjects(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $project = new Project();
            $project ->setProjectName('Project de Prueba');
            $project ->setProjectDescription('Some text '.rand(0,100));
            $project ->setProjectDate(new \Datetime(2019-03-12));

            $project->setUser($this->getReference('liviu'));
            
            $manager->persist($project);
        }
        $manager->flush();
    }
}