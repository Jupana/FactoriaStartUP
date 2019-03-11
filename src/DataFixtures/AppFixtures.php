<?php

namespace App\DataFixtures;

use App\Entity\User;
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
    }

    private function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('nicol');
        $user->setFullname('Nicoleta Laura');
        $user->setEmail('nicol@nicol.com');
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                'nicol123'
            )
        );
        $manager->persist($user);
        $manager->flush();
    }
}