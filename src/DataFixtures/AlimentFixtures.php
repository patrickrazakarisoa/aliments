<?php

namespace App\DataFixtures;

use App\Entity\Aliment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AlimentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $a1 = new Aliment();
        $a1->setNom("Carotte")
            ->setPrix(1.80)
            ->setImage("carotte.png")
            ->setCalorie(500)
            ->setProteine(12.36)
            ->setGlucide(2.23)
            ->setLipide(4.25);
        $manager->persist($a1);

        $a2 = new Aliment();
        $a2->setNom("Patate")
            ->setPrix(5.80)
            ->setImage("patate.jpg")
            ->setCalorie(1000)
            ->setProteine(2.36)
            ->setGlucide(6.23)
            ->setLipide(7.5);
        $manager->persist($a2);

        $a3 = new Aliment();
        $a3->setNom("Pomme")
            ->setPrix(3.80)
            ->setImage("pomme.png")
            ->setCalorie(500)
            ->setProteine(15.36)
            ->setGlucide(3.35)
            ->setLipide(5.5);
        $manager->persist($a3);

        $a4 = new Aliment();
        $a4->setNom("Tomate")
            ->setPrix(5.80)
            ->setImage("tomate.png")
            ->setCalorie(5000)
            ->setProteine(25.36)
            ->setGlucide(4.23)
            ->setLipide(9.25);
        $manager->persist($a4);


        $manager->flush();
    }
}
