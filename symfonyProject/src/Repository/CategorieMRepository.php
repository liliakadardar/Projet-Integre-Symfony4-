<?php

namespace App\Repository;

use App\Entity\CategorieM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieM|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieM|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieM[]    findAll()
 * @method CategorieM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieM::class);
    }

    // /**
    //  * @return CategorieM[] Returns an array of CategorieM objects
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
    public function findOneBySomeField($value): ?CategorieM
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
