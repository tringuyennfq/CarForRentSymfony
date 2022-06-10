<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/api/error', name: 'app_api_error')]
    public function show(): Response
    {
        return $this->json(['Error' => '404 Page not found'], 404);
    }
}
