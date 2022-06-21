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
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CarController extends AbstractController
{
    use JsonResponseTrait;

    #[Route('/api/cars/', name: 'api_list_car', methods: 'GET')]
    public function listCars(
        Request            $request,
        CarFilterRequest   $carListingRequest,
        ValidatorInterface $validator,
        CarRepository      $carRepository,
        CarTransformer     $carTransformer
    ): JsonResponse
    {
        $data = $request->query->all();
        $carListingRequest->fromArray($data);
        $error = $validator->validate($carListingRequest);
        if (count($error) > 0) {
            throw new ValidatorException(code: Response::HTTP_BAD_REQUEST);
        }
        $result = $carTransformer->toArrayList($carRepository->all($carListingRequest));
        return $this->success($result);
    }

    #[Route('/api/cars/{id}', name: 'api_show_car', methods: 'GET')]
    public function carDetails(int $id, CarRepository $carRepository, CarTransformer $carTransformer): JsonResponse
    {
        $car = $this->checkCarId($id, $carRepository);
        $result = $carTransformer->toArray($car);
        return $this->success($result);
    }

    #[Route('/api/cars', name: 'api_add_car', methods: 'POST')]
    #[IsGranted('ROLE_ADMIN')]
    public function addCar(
        AddCarRequest      $addCarRequest,
        Request            $request,
        ValidatorInterface $validator,
        CarService         $carService
    ): JsonResponse
    {
        $array = json_decode($request->getContent(), true);
        $addCarRequest->fromArray($array);
        $error = $validator->validate($addCarRequest);
        if (count($error) > 0) {
            throw new ValidatorException(code: Response::HTTP_BAD_REQUEST);
        }
        $carService->addCar($addCarRequest);
        return $this->success('Car added successfully', Response::HTTP_CREATED);
    }

    #[Route('/api/cars/{id}', name: 'api_delete_car', methods: 'DELETE')]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteCar(
        int        $id,
        CarService $carService,
        CarRepository $carRepository
    ): JsonResponse
    {
        $car = $this->checkCarId($id, $carRepository);
        $carService->deleteCar($car);
        return $this->success('Car deleted successfully', Response::HTTP_OK);
    }

    #[Route('/api/cars/{id}', name: 'api_put_car', methods: 'PUT')]
    #[IsGranted('ROLE_ADMIN')]
    public function putCar(
        int                $id,
        CarService         $carService,
        CarRepository      $carRepository,
        PutCarRequest      $putCarRequest,
        Request            $request,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $array = json_decode($request->getContent(), true);
        $putCarRequest->fromArray($array);
        $error = $validator->validate($putCarRequest);
        if (count($error) > 0) {
            throw new ValidatorException(code: Response::HTTP_BAD_REQUEST);
        }
        $car = $this->checkCarId($id, $carRepository);
        $carService->putCar($putCarRequest, $car);
        return $this->success('Car updated successfully', Response::HTTP_OK);
    }

    #[Route('/api/cars/{id}', name: 'api_patch_car', methods: 'PATCH')]
    #[IsGranted('ROLE_ADMIN')]
    public function patchCar(
        int                $id,
        CarService         $carService,
        CarRepository      $carRepository,
        PatchCarRequest    $patchCarRequest,
        Request            $request,
        ValidatorInterface $validator,
    ): JsonResponse
    {
        $array = json_decode($request->getContent(), true);
        $patchCarRequest->fromArray($array);
        $error = $validator->validate($patchCarRequest);
        $car = $this->checkCarId($id, $carRepository);
        if (count($error) > 0) {
            throw new ValidatorException(code: Response::HTTP_BAD_REQUEST);
        }
        $carService->patchCar($patchCarRequest, $car);
        return $this->success('Car updated successfully', Response::HTTP_OK);
    }

    private function checkCarId(int $id, CarRepository $carRepository): Car
    {
        $car = $carRepository->find($id);
        if ($car === null) {
            throw new ValidatorException(code: Response::HTTP_BAD_REQUEST);
        }
        return $car;
    }
}
