<?php

namespace App\Repository;

use App\Entity\CommandeT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommandeT|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeT|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeT[]    findAll()
 * @method CommandeT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeT::class);
    }

    // /**
    //  * @return CommandeT[] Returns an array of CommandeT objects
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
    public function findOneBySomeField($value): ?CommandeT
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
