<?php

namespace App\Repository;

use App\Entity\CategorieT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieT|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieT|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieT[]    findAll()
 * @method CategorieT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieT::class);
    }


    /**
     *
     * Requête QueryBuilder
     */
    public function listCategorieParType(){
        return $this->createQueryBuilder('c')
            ->orderBy('c.type_transport','DESC')
            ->getQuery()
            ->getResult()

            ;

    }


    // /**
    //  * @return CategorieT[] Returns an array of CategorieT objects
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
    public function findOneBySomeField($value): ?CategorieT
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
