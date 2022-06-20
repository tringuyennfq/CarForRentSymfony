<?php

namespace App\Transformer;

use App\Entity\User;

class UserTransformer extends AbstractTransformer
{
    const ATTRIBUTES = ['id', 'name', 'name'];
    public function toArray(User $user): array
    {
        return $this->transform($user, self::ATTRIBUTES);
    }
}
