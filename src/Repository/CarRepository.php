<?php

namespace App\Repository;

use App\Entity\Car;
use App\Request\CarListingRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends BaseRepository
{
    const CAR_ALIAS = 'c';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class, static::CAR_ALIAS);
    }

    public function all(CarListingRequest $carListingRequest)
    {
        $qb = $this->createQueryBuilder(static::CAR_ALIAS);
        $qb = $this->sortBy($qb, $carListingRequest->getOrderBy(), $carListingRequest->getOrderType());
        $qb = $this->filter($qb, 'color', $carListingRequest->getColor());
        $qb = $this->andFilter($qb, 'brand', $carListingRequest->getBrand());
        $qb = $this->andFilter($qb, 'seats', $carListingRequest->getSeats());
        $qb->setMaxResults($carListingRequest->getLimit())->setFirstResult($carListingRequest->getOffset());
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @return Car[] Returns an array of Car objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBySomeField($value): ?Car
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
