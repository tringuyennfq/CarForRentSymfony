<?php

namespace App\Controller\API;

use App\Traits\JsonResponseTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    use JsonResponseTrait;

    #[Route('/api/login', name: 'api_login')]
    public function login(JWTTokenManagerInterface $JWTTokenManager): JsonResponse
    {
        $user = $this->getUser();

        if ($user == null) {
            return $this->error('Credentials invalid', Response::HTTP_BAD_REQUEST);
        }
        $token = $JWTTokenManager->create($user);
        return $this->success(['token' => $token], Response::HTTP_OK);
    }
}
