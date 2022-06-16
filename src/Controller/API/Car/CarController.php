<?php

namespace App\Controller\API\Car;

use App\Request\CarListingRequest;
use App\Traits\JsonResponseTrait;
use Cassandra\Exception\ValidationException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CarController extends AbstractController
{
    use JsonResponseTrait;

//    #[Route('/api/cars/', name: 'api_car', methods: 'GET')]
//    public function all(CarRepository $carRepository, CarTransformer $carTransformer): JsonResponse
//    {
//        $carList = $carTransformer->toArrayList($carRepository->findAll());
//        return $this->success($carList);
//    }

    #[Route('/api/cars/', name: 'api_list_car', methods: 'GET')]
    public function listCars(Request $request, CarListingRequest $carListingRequest, ValidatorInterface $validator)
    {
        $data = $request->query->all();
        $carListingRequest->fromArray($data);
        $error = $validator->validate($carListingRequest);
        if (count($error)>1) {
            throw new Exception('hoai ngu');
        }
        dd('ok');
    }
}
