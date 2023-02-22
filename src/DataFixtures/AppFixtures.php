<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher,){}


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach(range(1,3) as $i){
            $user = new User();
            $user
                ->setUsername($faker->userName())
                ->setPassword($this->hasher->hashPassword($user, '12345'))
                ->setRoles(['ROLE_MANAGER'])
            ;
    
            $manager->persist($user);
        }
       

        foreach(range(1,3) as $i){
            $user = new User();
            $user
                ->setUsername($faker->userName())
                ->setPassword($this->hasher->hashPassword($user, '12345'))
                ->setRoles(['ROLE_ADMIN'])
            ;
    
            $manager->persist($user);
        }
        $manager->flush();
    }
}
