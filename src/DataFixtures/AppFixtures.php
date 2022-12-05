<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Recette;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $admin = new User();
        $this->CreateUsers($manager, $user, $admin);

        for ($i = 0; $i < 20; $i++)
        {
            $recette = new Recette();
            $category = new Category();

            $category->setName('Végétarien'.$i);
            $manager->persist($category);

            $recette->setDescriptions('description here'.$i);
            $recette->setName('Name here'.$i);
            $recette->setUsers($user);
            $recette->setImage('image : '.$i);
            $recette->addCategory($category);

            $manager->persist($recette);
        }
        $manager->flush();
    }

    private function CreateUsers(ObjectManager $manager,User $user, User $admin) : void
    {
        $user->setEmail('boddaert.gauthier@gmail.com');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "coucou"));
        $user->setRoles(['user']);

        $admin->setEmail('gboddaert@insitaction.com');
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, "coucou"));
        $admin->setRoles(['admin']);

        $manager->persist($user);
        $manager->persist($admin);

    }
}
