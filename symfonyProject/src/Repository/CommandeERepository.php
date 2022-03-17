<?php

namespace App\Repository;

use App\Entity\CommandeE;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommandeE|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeE|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeE[]    findAll()
 * @method CommandeE[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeERepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeE::class);
    }

    // /**
    //  * @return CommandeE[] Returns an array of CommandeE objects
    //  */
    /*
    public function findByExampleField($value)
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
    */

    /*
    public function findOneBySomeField($value): ?CommandeE
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
