<?php

namespace App\Transformer;

use App\Entity\Rent;

class RentTransformer extends AbstractTransformer
{
    const ATTRIBUTE = ['status', 'startDate', 'endDate', 'createdAt', 'updatedAt'];
    public function toArray(Rent $rent): array
    {
        $result = $this->transform($rent, self::ATTRIBUTE);
        $result['user'] = $rent->getUser()->getEmail();
        $result['car'] = $rent->getCar()->getName();
        return $result;
    }

    public function toArrayList(array $rents): array
    {
        $rentList = [];
        foreach ($rents as $rent) {
            $rentList[] = $this->toArray($rent);
        }
        return$rentList;
    }
}
