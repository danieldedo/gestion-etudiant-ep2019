<?php

namespace App\DataFixtures;

use App\Entity\Option;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail("admin@gmail.com");
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword("admin123");
        
        $option1 = new Option();
        $option1->setCodopt("AGE");
        $option1->setNomopt("Administration et gestion des entreprises");
        
        $option2 = new Option();
        $option2->setCodopt("AGRO");
        $option2->setNomopt("Agronomie");
        
        $option3 = new Option();
        $option3->setCodopt("RIT");
        $option3->setNomopt("Réseaux Informatiques et Télécommunications");
        
        $option4 = new Option();
        $option4->setCodopt("SIL");
        $option4->setNomopt("Systemes Informatiques et Logiciels");

        $manager->persist($user);
        $manager->persist($option1);
        $manager->persist($option2);
        $manager->persist($option3);
        $manager->persist($option4);
        $manager->flush();
    }
}
