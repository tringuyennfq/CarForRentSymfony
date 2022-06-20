<?php

namespace App\Mapping;

use App\Entity\Car;
use App\Entity\User;
use App\Repository\ImageRepository;
use App\Request\AddCarRequest;

class AddCarRequestToCar
{
    private ImageRepository $imageRepository;
    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function mapping(AddCarRequest $addCarRequest, User $createdUser): Car
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
