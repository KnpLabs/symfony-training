<?php

namespace App\Repository;

use App\Entity\Dinosaur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class DinosaurRepository extends ServiceEntityRepository
{
    private const alias = 'dinosaur';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dinosaur::class);
    }

    /**
     * @param array<string, string> $filter
     * @param array<string, 'DESC'|'ASC'> $sorts
     */
    public function search(
        ?string $q = null,
        ?array $filters = null,
        ?array $sorts = null,
        ?int $page = 0,
        ?int $limit = 25
    ): array {
        $queryBuilder = $this->createQueryBuilder(self::alias);

        if (null === $q) {
            $queryBuilder
                ->where(sprintf('%s.name = :q', self::alias))
                ->setParameter('q', $q);
        }

        if (null !== $filters) {
            $queryBuilder = $this->filter($queryBuilder, $filters);
        }

        if (null !== $sorts) {
            $queryBuilder = $this->sort($queryBuilder, $sorts);
        }

        return $queryBuilder
            ->getQuery()
            ->setFirstResult($page * $limit)
            ->setMaxResults($limit)
            ->getResult();
    }

    /**
     * @param array<string, string> $filters
     */
    private function filter(QueryBuilder $queryBuilder, array $filters): QueryBuilder
    {
        foreach ($filters as $property => $value) {
            $queryBuilder
                ->andWhere(sprintf('%s.%s = %s', self::alias, $property, $value));
        }

        return $queryBuilder;
    }

    private function sort(QueryBuilder $queryBuilder, array $sorts): QueryBuilder
    {
        foreach ($sorts as $property => $direction) {
            $queryBuilder
                ->addOrderBy(sprintf('%s.%s', self::alias, $property), $direction);
        }

        return $queryBuilder;
    }
}
