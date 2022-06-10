<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $car1 = new Car();
        $car1->setName('Mustang');
        $car1->setColor('red');
        $car1->setPrice(123);
        $car1->setBrand('Ford');
        $car1->setProductionYear(2020);
        $car1->setImagePath('https://tricarrent.s3.ap-southeast-1.amazonaws.com/70f770b15ce98828914eef304d409e2fford-mustang-2020.png');
        $manager->persist($car1);

        $car2 = new Car();
        $car2->setName('Travel Home');
        $car2->setColor('green');
        $car2->setPrice(123);
        $car2->setBrand('Mercedes-Benz');
        $car2->setProductionYear(2020);
        $car2->setImagePath('https://tricarrent.s3.ap-southeast-1.amazonaws.com/mercides-benz-travelhome.jpeg');
        $manager->persist($car2);

        $manager->flush();
    }
}
