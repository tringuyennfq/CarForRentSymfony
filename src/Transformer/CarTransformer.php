<?php

namespace App\Transformer;

use App\Entity\Car;
use App\Entity\User;
use App\Repository\ImageRepository;
use App\Request\AddCarRequest;
use Symfony\Component\Security\Core\Security;

class CarTransformer extends AbstractTransformer
{
    const ATTRIBUTE = ['name', 'brand', 'color', 'price', 'seats'];
    private ImageRepository $imageRepository;
    public function __construct( ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function toArray(Car $car): array
    {
        $result = $this->transform($car, self::ATTRIBUTE);
        $result['thumbnail'] = $car->getThumbnail()->getPath();
        $result['createdUser'] = $car->getCreatedUser()->getEmail();
        return $result;
    }

    public function toArrayList(array $cars): array
    {
        $carList = [];
        foreach ($cars as $car) {
            $carList[] = $this->toArray($car);
        }
        return $carList;
    }

    public function toEntity(AddCarRequest $addCarRequest, User $createdUser): Car
    {
        $car = new Car();
        $car->setName($addCarRequest->getName());
        $car->setBrand($addCarRequest->getBrand());
        $car->setColor($addCarRequest->getColor());
        $car->setPrice($addCarRequest->getPrice());
        $car->setDescription($addCarRequest->getDescription());
        $car->setYear($addCarRequest->getYear());
        $car->setSeats($addCarRequest->getSeats());
        $car->setCreatedAt(new \DateTimeImmutable('now'));
        $car->setThumbnail($this->imageRepository->find($addCarRequest->getThumbnailId()));
        $car->setCreatedUser($createdUser);
        return $car;
    }
}
