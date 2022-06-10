<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class UserLoginService
{
    public function getJsonBody(Request $request): ?array
    {
        $data = json_decode($request->getContent(), true);
        if ($data) {
            return [
                'username' => $data['username'],
                'password' => $data['password']
            ];
        }
        return null;
    }
}
