<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CarListingRequest extends BaseRequest
{
    const ORDER = ['created', 'price'];
    const SEATS = [4, 7, 16];

    #[Assert\Choice(choices: self::ORDER, message: 'choose a valid order')]
    private $orderBy;

    #[Assert\Type('string')]
    private $color;

    #[Assert\Type('string')]
    private $brand;

    #[Assert\Choice(choices: self::SEATS, message: 'choose a valid seat type')]
    private $seats;

    /**
     * @return mixed
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param mixed $orderBy
     */
    public function setOrderBy($orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * @param mixed $seats
     */
    public function setSeats($seats): void
    {
        $this->seats = $seats;
    }


}
