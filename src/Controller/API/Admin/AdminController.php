<?php

namespace App\Controller\API\Admin;

use App\Traits\JsonResponseTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    use JsonResponseTrait;
    #[Route('/api/admin', name: 'api_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): JsonResponse
    {
        return $this->success(['message' => 'Hello admin']);
    }
}
