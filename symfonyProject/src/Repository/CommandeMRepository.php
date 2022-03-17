<?php

namespace App\Repository;

use App\Entity\CommandeM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommandeM|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeM|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeM[]    findAll()
 * @method CommandeM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeM::class);
    }

    // /**
    //  * @return CommandeM[] Returns an array of CommandeM objects
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
    public function findOneBySomeField($value): ?CommandeM
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
