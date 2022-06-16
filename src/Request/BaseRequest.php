<?php

namespace App\Request;

class BaseRequest
{
    public function fromArray(array $array)
    {
        foreach ($array as $key => $value) {
            $action = 'set' . ucfirst($key);
            if (!method_exists($this, $action)) {
                continue;
            }
            $this->{$action}($value);
        }
        return $this;
    }
}
