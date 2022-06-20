<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\CarRepository;
use App\Repository\ImageRepository;
use App\Request\AddCarRequest;
use App\Transformer\CarTransformer;
use Symfony\Component\Security\Core\Security;

class CarService
{
    private CarRepository $carRepository;
    private ImageRepository $imageRepository;
    private Security $security;
    private CarTransformer $carTransformer;

    public function __construct(
        CarRepository   $carRepository,
        ImageRepository $imageRepository,
        Security        $security,
        CarTransformer  $carTransformer
    ) {
        $this->carRepository = $carRepository;
        $this->imageRepository = $imageRepository;
        $this->carTransformer = $carTransformer;
        $this->security = $security;
    }

    public function addCar(AddCarRequest $addCarRequest): void
    {
        /**
         * @var User $user
         */
        $user = $this->security->getUser();
        $car = $this->carTransformer->toEntity($addCarRequest, $user);
        $this->carRepository->add($car, true);
    }
}
