<?php

namespace App\Controller\Car;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarDetailsController extends AbstractController
{
    private CarRepository $carRepository;
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    #[Route('/car/{id}', name: 'app_car_details', methods: ['GET'])]
    public function index(Car $car): Response
    {
        return $this->render('car_details/index.html.twig', [
            'car' => $car,
        ]);
    }
}
