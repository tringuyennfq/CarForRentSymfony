<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationFailureListener
{

    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event): void
    {
        $result = [
            'status' => 'error',
            'message' => 'Credentials invalid'
        ];
        $response = new JsonResponse($result, Response::HTTP_UNAUTHORIZED);
        $event->setResponse($response);
    }
}
