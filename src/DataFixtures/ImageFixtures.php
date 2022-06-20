<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Monolog\DateTimeImmutable;

class ImageFixtures extends Fixture
{

    public static function getImageReferenceKey(mixed $id)
    {
        return sprintf('image_%s', $id);
    }

    public function load(ObjectManager $manager)
    {
        $createdAt = new DateTimeImmutable(false);
        $arr = [
            [
                'id' => 1,
                'path' => 'https://tricarrent.s3.ap-southeast-1.amazonaws.com/70f770b15ce98828914eef304d409e2fford-mustang-2020.png',
                'createdAt' => $createdAt,
            ],
            [
                'id' => 2,
                'path' => 'https://tricarrent.s3.ap-southeast-1.amazonaws.com/12c94dfdf00112ff2578180c5c8e4712chevrolet-camaro.png',
                'createdAt' => $createdAt,
            ],
        ];
        foreach ($arr as $param) {
            $image = new Image();
            $image
                ->setPath($param['path'])
                ->setCreatedAt($createdAt);
            $manager->persist($image);
            $this->setReference(self::getImageReferenceKey($param['id']), $image);
        }
        $manager->flush();
    }
}
