<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private CarRepository $carRepository;
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    #[Route(['/home','/'], name: 'app_index')]
    public function index(): Response
    {
        $carList = $this->carRepository->findAll();
        return $this->render('index.html.twig',['cars' => $carList]);
    }
}
