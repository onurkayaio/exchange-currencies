<?php

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CurrencyRepository extends ServiceEntityRepository
{
    protected $entityClass = Currency::class;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, $this->entityClass);
    }

    public function findCurrencies()
    {
        $qb = $this->createQueryBuilder('c')->select('c');

        $result = $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);

        return $result;
    }

    public function getCurrenciesByProvider($provider)
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->select('c')
            ->where('c.provider = :provider')
            ->setParameter('provider', $provider);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result;
    }
}