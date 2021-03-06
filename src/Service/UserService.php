<?php

namespace App\Service;

use Symfony\Component\Security\Core\Security;

class UserService
{
    private $security;
    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }
}
