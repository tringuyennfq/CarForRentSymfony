<?php

namespace App\Controller\API\Car;

use App\Repository\CarRepository;
use App\Request\AddCarRequest;
use App\Request\CarFilterRequest;
use App\Service\CarService;
use App\Traits\JsonResponseTrait;
use App\Transformer\CarTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidatorException;
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
    public function listCars(
        Request            $request,
        CarFilterRequest   $carListingRequest,
        ValidatorInterface $validator,
        CarRepository      $carRepository,
        CarTransformer     $carTransformer
    ) {
        $data = $request->query->all();
        $carListingRequest->fromArray($data);
        $error = $validator->validate($carListingRequest);
        if (count($error) > 0) {
            throw new ValidatorException(code: Response::HTTP_BAD_REQUEST);
        }
        $result = $carTransformer->toArrayList($carRepository->all($carListingRequest));
        return $this->success($result);
    }

    #[Route('/api/cars', name: 'api_add_car', methods: 'POST')]
    #[IsGranted('ROLE_ADMIN')]
    public function addCar(
        AddCarRequest      $addCarRequest,
        Request            $request,
        ValidatorInterface $validator,
        CarService         $carService
    ) {
        $array = json_decode($request->getContent(), true);
        $addCarRequest->fromArray($array);
        $error = $validator->validate($addCarRequest);
        if (count($error) > 0) {
            throw new ValidatorException(code: Response::HTTP_BAD_REQUEST);
        }
        $carService->addCar($addCarRequest);
        return $this->success('Car added successfully', Response::HTTP_CREATED);
    }
}
