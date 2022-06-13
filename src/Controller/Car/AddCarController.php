<?php

namespace App\Controller\Car;

use App\Entity\Car;
use App\Form\AddCarType;
use App\Service\CarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddCarController extends AbstractController
{
    private CarService $carService;
    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    #[Route('/car/add', name: 'app_add_car', methods: ['GET','POST'])]
    public function show(Request $request): Response
    {
        $car =  new Car();
        $addCarForm = $this->createForm(AddCarType::class, $car);
        $addCarForm->handleRequest($request);
        if ($addCarForm->isSubmitted() && $addCarForm->isValid()) {
            $isAddCarSuccess =  $this->carService->addCar($car, $addCarForm->get('imagePath')->getData());
            if ($isAddCarSuccess != null) {
                $this->addFlash(
                    'message',
                    'Car created!'
                );
            } else {
                $this->addFlash(
                    'message',
                    'Car not created!'
                );
            }
        }
        return $this->render('/add_car/index.html.twig', [
            'addCarForm' => $addCarForm->createView(),
        ]);
    }
}
