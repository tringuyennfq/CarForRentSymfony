<?php

namespace App\Transformer;

use App\Entity\Car;
use App\Repository\ImageRepository;

class CarTransformer extends AbstractTransformer
{
    const ATTRIBUTE = ['name', 'brand', 'color', 'price', 'seats'];
    private ImageRepository $imageRepository;

    public function __construct(ImageRepository $imageRepository)
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
}
