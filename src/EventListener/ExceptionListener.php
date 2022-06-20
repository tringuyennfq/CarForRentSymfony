<?php

namespace App\EventListener;

use App\Traits\JsonResponseTrait;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class ExceptionListener
{
    use JsonResponseTrait;

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = $this->error('Internal error', Response::HTTP_INTERNAL_SERVER_ERROR);
        if ($exception instanceof HttpExceptionInterface) {
            $response = $this->error($exception->getMessage(), $exception->getCode());
        }
        if ($exception instanceof AccessDeniedHttpException) {
            $response = $this->error($exception->getMessage(), $exception->getCode());
        }
        if ($exception instanceof ValidatorException) {
            $response = $this->error('Bad request', $exception->getCode());
        } elseif ($exception instanceof Exception) {
            $response = $this->error($exception->getMessage(), $exception->getCode());
        }
        $event->setResponse($response);
    }
}
