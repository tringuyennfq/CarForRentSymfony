<?php

namespace App\Controller\API;

use App\Service\UserLoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserLoginController extends AbstractController
{
    const JSON_HEADER = ['Content-Type' => 'application/json;charset=UTF-8'];
    private UserLoginService $userLoginService;

    public function __construct(UserLoginService $userLoginService)
    {
        $this->userLoginService = $userLoginService;
    }

    #[Route('/api/user/login', name: 'app_api_user_login')]
    public function index(Request $request): JsonResponse
    {
        $jsonBody = $this->userLoginService->getJsonBody($request);
        if ($jsonBody != null) {
            return $this->json($jsonBody, Response::HTTP_OK, self::JSON_HEADER);
        }
        return $this->json(['Error' => 'Credentials not found!'], Response::HTTP_NOT_FOUND);
    }
}
