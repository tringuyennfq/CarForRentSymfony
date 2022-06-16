<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Monolog\DateTimeImmutable;

class UserFixtures extends Fixture
{
    public static function getUserReferenceKey($id)
    {
        return sprintf('user_%s', $id);
    }

    public function load(ObjectManager $manager)
    {
        $arr = [
            [
                'id' => 1,
                'name' => 'Nguyen Huynh Khai Tri',
                'password' => password_hash('123456', PASSWORD_BCRYPT),
                'email' => 'cptdouge@gmail.com',
                'roles' => ['role' => 'ROLE_ADMIN'],
                'createdAt' => new DateTimeImmutable(false)
            ],
            [
                'id' => 2,
                'name' => 'To Le Hoai',
                'password' => password_hash('123456', PASSWORD_BCRYPT),
                'email' => 'tolehoai@gmail.com',
                'roles' => [],
                'createdAt' => new DateTimeImmutable(false)
            ],
        ];
        foreach ($arr as $param) {
            $user = new User();
            $user
                ->setPassword($param['password'])
                ->setName($param['name'])
                ->setEmail($param['email'])
                ->setRoles($param['roles'])
                ->setCreatedAt($param['createdAt']);
            $manager->persist($user);
            $this->setReference(self::getUserReferenceKey($param['id']), $user);
        }
        $manager->flush();
    }
}
