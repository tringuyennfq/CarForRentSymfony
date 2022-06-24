<?php

namespace App\Controller\API;

use App\Repository\RentRepository;
use App\Service\RentService;
use App\Traits\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RentController extends AbstractController
{
    use JsonResponseTrait;
    #[Route('/api/rent', name: 'api_rent')]
    public function rent(RentService $rentService): Response
    {
        dd($rentService->availableCheck(4));
        return $this->success();
    }
}
