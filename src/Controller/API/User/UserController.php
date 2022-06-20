<?php

namespace App\Controller\API\User;

use App\Traits\JsonResponseTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    use JsonResponseTrait;
    #[Route('/api/user', name: 'api_user')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        return $this->success(['message' => 'Hello user']);
    }
}
