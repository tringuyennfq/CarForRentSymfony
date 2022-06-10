<?php

namespace App\Service;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CarService
{
    private CarRepository $carRepository;
    private FileUploadService $fileUploadService;
    public function __construct(CarRepository $carRepository, FileUploadService $fileUploadService)
    {
        $this->carRepository = $carRepository;
        $this->fileUploadService = $fileUploadService;
    }

    public function addCar(Car $car, UploadedFile $uploadedFile): ?Car
    {
        $carImageName= $this->fileUploadService->upload($uploadedFile);
        if ($carImageName != null) {
            $carImagePath = $carImageName;
            $car->setImagePath($carImagePath);
            $this->carRepository->add($car, true);
            return $car;
        }
        return null;
    }
}
