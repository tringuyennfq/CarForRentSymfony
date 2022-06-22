<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationList;

trait JsonResponseTrait
{
    protected function error($message, int $statusCode = 400): JsonResponse
    {
        $result = [
            'status' => 'error',
            'message' => $message
        ];
        return new JsonResponse($result, $statusCode);
    }

    protected function success(mixed $data = [], int $statusCode = 200): JsonResponse
    {
        $result = [
            'status' => 'success',
            'data' => $data
        ];
        return new JsonResponse($result, $statusCode);
    }
    protected function getValidationErrors(ConstraintViolationList $errors): array
    {
        $result = [];
        foreach ($errors as $error){
            $result[$error->getPropertyPath()] = $error->getMessage();
        }
        return $result;
    }
}
