<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class BaseRepository extends ServiceEntityRepository
{
    private string $alias;

    public function __construct(ManagerRegistry $registry, string $entityClass = '', string $alias = '')
    {
        parent::__construct($registry, $entityClass);
        $this->alias = $alias;
    }

    public function add(AbstractEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AbstractEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function sortBy(QueryBuilder $queryBuilder, ?string $orderBy, ?string $orderType): QueryBuilder
    {
        if ($orderType == null || $orderBy == null) {
            return $queryBuilder;
        }
        return $queryBuilder->orderBy($this->alias . ".$orderBy", $orderType);
    }

    public function filter(QueryBuilder $queryBuilder, string $key, ?string $value): QueryBuilder
    {
        if ($value == null) {
            return $queryBuilder;
        }
        return $queryBuilder->where($this->alias . ".$key = :$key")->setParameter($key, $value);
    }

    public function andFilter(QueryBuilder $queryBuilder, string $key, ?string $value): QueryBuilder
    {
        if ($value == null) {
            return $queryBuilder;
        }
        return $queryBuilder->andWhere($this->alias . ".$key = :$key")->setParameter($key, $value);
    }
}
