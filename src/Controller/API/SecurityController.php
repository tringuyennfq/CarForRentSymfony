<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/api', name: 'app_api_security')]
    public function index(): Response
    {
        return $this->render('api/security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
}
