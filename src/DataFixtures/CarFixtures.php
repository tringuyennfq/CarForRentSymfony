<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Monolog\DateTimeImmutable;

class CarFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $createdAt = new DateTimeImmutable(false);
        $arr = [
            [
                'id' => 1,
                'name' => 'Mustang',
                'createdUser' => $this->getReference(UserFixtures::getUserReferenceKey(1)),
                'thumbnail' => $this->getReference(ImageFixtures::getImageReferenceKey(1)),
                'brand' => 'Ford',
                'price' => 200,
                'color' => 'grey',
                'seats' => 4,
                'year' => 2020,
                'createdAt' => $createdAt,
            ],
            [
                'id' => 2,
                'name' => 'Camaro',
                'createdUser' => $this->getReference(UserFixtures::getUserReferenceKey(2)),
                'thumbnail' => $this->getReference(ImageFixtures::getImageReferenceKey(2)),
                'brand' => 'Chevrolet',
                'price' => 220,
                'color' => 'white',
                'seats' => 4,
                'year' => 2021,
                'createdAt' => $createdAt,
            ],
        ];


        foreach ($arr as $param) {
            $car1 = new Car();
            $car1
                ->setName($param['name'])
                ->setCreatedUser($param['createdUser'])
                ->setBrand($param['brand'])
                ->setPrice($param['price'])
                ->setColor($param['color'])
                ->setSeats($param['seats'])
                ->setYear($param['year'])
                ->setThumbnail($param['thumbnail'])
                ->setCreatedAt($param['createdAt']);
            $manager->persist($car1);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ImageFixtures::class
        ];
    }
}
