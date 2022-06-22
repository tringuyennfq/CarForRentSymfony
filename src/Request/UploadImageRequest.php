<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UploadImageRequest extends BaseRequest
{
    #[Assert\Image(
        maxSize: '3M',
        mimeTypes: [
            'image/jpeg',
            'image/jpg',
            'image/png'
        ],
        mimeTypesMessage: 'The type of the file is invalid ({{ type }}). Allowed types are {{ types }}.'
    )]
    private $image;


    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }


}