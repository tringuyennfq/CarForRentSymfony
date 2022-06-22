<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CarFilterRequest extends BaseRequest
{
    const ORDER_BY = ['createdAt', 'price'];
    const ORDER_TYPE = ['asc', 'desc'];
    const SEATS = [4, 7, 16];
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 10;

    #[Assert\Choice(choices: self::ORDER_BY, message: 'choose a valid order')]
    #[Assert\Type('string')]
    private $orderBy = 'createdAt';

    #[Assert\Choice(choices: self::ORDER_TYPE, message: 'choose a valid order type')]
    #[Assert\Type('string')]
    private $orderType = 'desc';

    #[Assert\Type('string')]
    private $color = null;

    #[Assert\Type('string')]
    private $brand = null;

    #[Assert\Choice(choices: self::SEATS, message: 'choose a valid seat type')]
    #[Assert\Type(type:'integer',message: 'choose a valid seat type')]
    private $seats;

    #[Assert\Type('integer')]
    private $offset = self::DEFAULT_OFFSET;

    #[Assert\Type('integer')]
    private $limit = self::DEFAULT_LIMIT;

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy(string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return string
     */
    public function getOrderType(): string
    {
        return $this->orderType;
    }

    /**
     * @param string $orderType
     */
    public function setOrderType(string $orderType): void
    {
        $this->orderType = $orderType;
    }

    /**
     * @return null
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param null $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    /**
     * @return null
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param null $brand
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
        $this->seats = is_numeric($seats) ? (int)$seats : $seats;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }


}
