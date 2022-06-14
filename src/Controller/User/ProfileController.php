<?php

namespace App\Controller\User;

use App\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/user/profile', name: 'app_user_profile')]
    #[IsGranted('ROLE_USER')]
    public function index(UserService $userService): Response
    {
        $user = $this->getUser();
        return $this->render('user/profile/index.html.twig', [
            'userEmail' => $user->getEmail() ?? '',
        ]);
    }
}
