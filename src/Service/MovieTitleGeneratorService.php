<?php

namespace App\Service;

class MovieTitleGeneratorService
{
    public function getTitle(): string
    {
        $arr = ['Avengers: Endgame', 'Inception', 'The Dark Knight', 'Everything everywhere all at once',
            'Coco', 'Tenet'];
        $index = array_rand($arr);
        return $arr[$index];
    }
}
