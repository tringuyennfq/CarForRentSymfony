<?php

namespace App\Service;

use App\Repository\RentRepository;
use App\Transformer\RentTransformer;

class RentService
{
    private RentRepository $rentRepository;
    private RentTransformer $rentTransformer;
    public function __construct(RentRepository $rentRepository, RentTransformer $rentTransformer)
    {
        $this->rentRepository = $rentRepository;
        $this->rentTransformer = $rentTransformer;
    }

    public function availableCheck(int $carId)
    {
        $result = $this->rentTransformer->toArrayList($this->rentRepository->findNewestRent($carId));
        return $result;
    }
}
