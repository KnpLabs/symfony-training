<?php

namespace App\Repository;

use App\Entity\Dinosaur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class DinosaurRepository extends ServiceEntityRepository
{
    private const ALIAS = 'dinosaur';

    private QueryBuilder $queryBuilder;
    private ManagerRegistry $registry;

    public function __construct(
        ManagerRegistry $registry,
        ?QueryBuilder $queryBuilder
    ) {
        parent::__construct($registry, Dinosaur::class);

        $this->registry = $registry;
        $this->queryBuilder = $queryBuilder ?: $this->createQueryBuilder(self::ALIAS);
    }


    public function search(?string $name = null): self
    {
        $queryBuilder = $this->cloneQueryBuilder();

        if ($name !== null) {
            $queryBuilder
                ->andWhere(sprintf('%s.name LIKE :name', self::ALIAS))
                ->setParameter('name', '%' . $name . '%');
        }

        return $this->duplicate($queryBuilder);
    }

    public function sort(array $sorts): self
    {
        $queryBuilder = $this->cloneQueryBuilder();

        foreach ($sorts as $field => $order) {
            $queryBuilder->addOrderBy(sprintf('%s.%s', self::ALIAS, $field), $order);
        }

        return $this->duplicate($queryBuilder);
    }

    public function filter(array $filters): self
    {
        $queryBuilder = $this->cloneQueryBuilder();

        foreach ($filters as $field => $value) {
            $queryBuilder
                ->andWhere(sprintf('%s.%s = :%s', self::ALIAS, $field, $field))
                ->setParameter($field, $value);
        }

        return $this->duplicate($queryBuilder);
    }

    public function paginate(int $page, int $limit): array
    {
        $queryBuilder = $this->cloneQueryBuilder();

        $queryBuilder
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return $queryBuilder->getQuery()->getResult();
    }

    private function cloneQueryBuilder(): QueryBuilder
    {
        return clone $this->queryBuilder;
    }

    private function duplicate(QueryBuilder $queryBuilder): self
    {
        return new self($this->registry, $queryBuilder);
    }
}
