<?php

namespace App\Controller\User;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/user/profile', name: 'app_user_profile')]
    public function index(UserService $userService): Response
    {
        $user = $this->getUser();
        return $this->render('user/profile/index.html.twig', [
            'userEmail' => $user->getEmail() ?? '',
        ]);
    }
}
