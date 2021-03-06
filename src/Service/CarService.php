<?php

namespace App\Service;

use App\Entity\Car;
use App\Entity\User;
use App\Mapping\AddCarRequestToCar;
use App\Mapping\PatchCarRequestToCar;
use App\Mapping\PutCarRequestToCar;
use App\Repository\CarRepository;
use App\Repository\ImageRepository;
use App\Request\AddCarRequest;
use App\Request\PatchCarRequest;
use App\Request\PutCarRequest;
use Symfony\Component\Security\Core\Security;

class CarService
{
    private CarRepository $carRepository;
    private ImageRepository $imageRepository;
    private Security $security;
    private AddCarRequestToCar $addCarRequestToCar;
    private PutCarRequestToCar $putCarRequestToCar;
    private PatchCarRequestToCar $patchCarRequestToCar;

    public function __construct(
        CarRepository        $carRepository,
        ImageRepository      $imageRepository,
        Security             $security,
        AddCarRequestToCar   $addCarRequestToCar,
        PutCarRequestToCar   $putCarRequestToCar,
        PatchCarRequestToCar $patchCarRequestToCar
    )
    {
        $this->carRepository = $carRepository;
        $this->imageRepository = $imageRepository;
        $this->security = $security;
        $this->addCarRequestToCar = $addCarRequestToCar;
        $this->putCarRequestToCar = $putCarRequestToCar;
        $this->patchCarRequestToCar = $patchCarRequestToCar;
    }

    public function addCar(AddCarRequest $addCarRequest): Car
    {
        /**
         * @var User $createdUser
         */
        $createdUser = $this->security->getUser();
        $car = $this->addCarRequestToCar->mapping($addCarRequest, $createdUser);
        $this->carRepository->add($car, true);
        return $car;
    }

    public function deleteCar(Car $car): void
    {
        $this->carRepository->remove($car, true);
    }

    public function putCar(PutCarRequest $putCarRequest, Car $car): Car
    {
        $this->putCarRequestToCar->mapping($putCarRequest, $car);
        $this->carRepository->add($car, true);
        return $car;
    }

    public function patchCar(PatchCarRequest $patchCarRequest, Car $car): Car
    {
        $this->patchCarRequestToCar->mapping($patchCarRequest, $car);
        $this->carRepository->add($car, true);
        return $car;
    }
}
