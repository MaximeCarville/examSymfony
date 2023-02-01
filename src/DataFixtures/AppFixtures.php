<?php

namespace App\DataFixtures;
use App\Entity\Divertissement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 126; $i++) {
            $divertissement = new Divertissement();
            $divertissement->setName('blabla '.$i);
            $divertissement->setSyno('blalsfdfg,lkqgq'.($i+550));
            $divertissement->setCreationDate(new \DateTimeImmutable());
            $divertissement->setType('maaax'.($i+236));
            $manager->persist($divertissement);
        }
        $manager->flush();
    }
}
