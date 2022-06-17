<?php

namespace App\Transformer;

use App\Entity\Image;

class ImageTransformer extends AbstractTransformer
{
    const ATTRIBUTES = ['id','path'];
    public function toArray(Image $image): array
    {
        $result = $this->transform($image, self::ATTRIBUTES);
        return $result;
    }
}
