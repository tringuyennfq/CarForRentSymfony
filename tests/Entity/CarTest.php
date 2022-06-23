<?php

namespace App\Tests\Entity;

namespace App\Tests\Entity;

use App\Entity\Car;
use App\Entity\Image;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    /**
     * @return void
     * @covers \App\Entity\Car
     * @dataProvider dataProvider
     */
    public function testGetSet($params)
    {
        $carTest = new Car();
        $carTest->setCreatedAt($params['date']);
        $carTest->setCreatedUser($params['user']);
        $carTest->setSeats($params['seats']);
        $carTest->setThumbnail($params['thumbnail']);
        $carTest->setYear($params['year']);
        $carTest->setDescription($params['description']);
        $carTest->setColor($params['color']);
        $carTest->setBrand($params['brand']);
        $carTest->setName($params['name']);
        $carTest->setPrice($params['price']);
        dd($carTest);
    }

    /**
     */
    public function dataProvider()
    {
        $params = [
            'date' => new \DateTimeImmutable(),
            'user' => new User(),
            'seats' => 4,
            'thumbnail' => new Image(),
            'year' => 2022,
            'description' => 'description',
            'color' => 'red',
            'brand' => 'Ford',
            'name' => 'Mustang',
            'price' => 200
        ];
        return [
            'params' => $params
        ];
    }
}
