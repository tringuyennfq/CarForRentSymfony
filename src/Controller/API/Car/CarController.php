<?php

namespace App\Controller\API\Car;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Request\AddCarRequest;
use App\Request\CarFilterRequest;
use App\Request\PatchCarRequest;
use App\Request\PutCarRequest;
use App\Service\CarService;
use App\Traits\JsonResponseTrait;
use App\Transformer\CarTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CarController extends AbstractController
{
    use JsonResponseTrait;

    #[Route('/api/cars/', name: 'api_list_car', methods: 'GET')]
    public function listCars(
        Request            $request,
        CarFilterRequest   $carFilterRequest,
        ValidatorInterface $validator,
        CarRepository      $carRepository,
        CarTransformer     $carTransformer
    ): JsonResponse
    {
        $data = $request->query->all();
        $carFilterRequest->fromArray($data);
        $errors = $validator->validate($carFilterRequest);
        if (count($errors) > 0) {
            return $this->error($this->getValidationErrors($errors), Response::HTTP_BAD_REQUEST);
        }
        $result = $carTransformer->toArrayList($carRepository->all($carFilterRequest));
        return $this->success($result);
    }

    #[Route('/api/cars/{id}', name: 'api_show_car', methods: 'GET')]
    public function carDetails(Car $car, CarTransformer $carTransformer): JsonResponse
    {
        $result = $carTransformer->toArray($car);
        return $this->success($result);
    }

    #[Route('/api/cars', name: 'api_add_car', methods: 'POST')]
    #[IsGranted('ROLE_ADMIN')]
    public function addCar(
        AddCarRequest      $addCarRequest,
        Request            $request,
        ValidatorInterface $validator,
        CarService         $carService,
        CarTransformer     $carTransformer
    ): JsonResponse
    {
        $array = json_decode($request->getContent(), true);
        $addCarRequest->fromArray($array);
        $errors = $validator->validate($addCarRequest);
        if (!count($errors) > 0) {
            return $this->error($this->getValidationErrors($errors), Response::HTTP_BAD_REQUEST);
        }
        $carAdded = $carService->addCar($addCarRequest);
        return $this->success($carTransformer->toArray($carAdded), Response::HTTP_CREATED);
    }

    #[Route('/api/cars/{id}', name: 'api_delete_car', methods: 'DELETE')]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteCar(
        Car        $car,
        CarService $carService
    ): JsonResponse
    {
        $carService->deleteCar($car);
        return $this->success(statusCode: Response::HTTP_NO_CONTENT);
    }


    #[Route('/api/cars/{id}', name: 'api_put_car', methods: 'PUT')]
    #[IsGranted('ROLE_ADMIN')]
    public function putCar(
        Car                $car,
        CarService         $carService,
        PutCarRequest      $putCarRequest,
        Request            $request,
        ValidatorInterface $validator,
        CarTransformer     $carTransformer
    ): JsonResponse
    {
        $array = json_decode($request->getContent(), true);
        $putCarRequest->fromArray($array);
        $errors = $validator->validate($putCarRequest);
        if (count($errors) > 0) {
            return $this->error($this->getValidationErrors($errors), Response::HTTP_BAD_REQUEST);
        }
        $carService->putCar($putCarRequest, $car);
        return $this->success($carTransformer->toArray($car));
    }

    #[Route('/api/cars/{id}', name: 'api_patch_car', methods: 'PATCH')]
    #[IsGranted('ROLE_ADMIN')]
    public function patchCar(
        Car                $car,
        CarService         $carService,
        PatchCarRequest    $patchCarRequest,
        Request            $request,
        ValidatorInterface $validator,
        CarTransformer     $carTransformer
    ): JsonResponse
    {
        $array = json_decode($request->getContent(), true);
        $patchCarRequest->fromArray($array);
        $errors = $validator->validate($patchCarRequest);
        if (count($errors) > 0) {
            return $this->error($this->getValidationErrors($errors), Response::HTTP_BAD_REQUEST);
        }
        $carService->patchCar($patchCarRequest, $car);
        return $this->success($carTransformer->toArray($car));
    }
}
