<?php

namespace App\Transformer;

use App\Entity\Car;

class CarTransformer
{
    public function toArray(Car $car): array
    {
        return [
            'name' => $car->getName(),
            'brand' => $car->getBrand(),
            'price' => $car->getPrice(),
            'thumbnail' => $car->getThumbnail()->getPath(),
            'createdUser' => $car->getCreatedUser()->getEmail(),
        ];
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
