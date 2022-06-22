<?php

namespace App\EventListener;

use App\Traits\JsonResponseTrait;
use Aws\S3\Exception\S3Exception;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Exception\ValidatorException;

class ExceptionListener
{
    use JsonResponseTrait;

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = $this->error('Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);

        if ($exception instanceof HttpExceptionInterface) {
            $response = $this->error($exception->getMessage(), $exception->getStatusCode());
        }
        else if ($exception instanceof ValidatorException) {
            $response = $this->error('Bad request', $exception->getCode());
        }
        else if ($exception instanceof S3Exception) {
            $response = $this->error('S3 upload error', $exception->getCode());
        }
        else if ($exception instanceof FileException) {
            $response = $this->error('File upload error', $exception->getCode());
        }
        else if ($exception instanceof InvalidArgumentException) {
            $response = $this->error($exception->getMessage(), $exception->getCode());
        }
        $event->setResponse($response);
    }
}
