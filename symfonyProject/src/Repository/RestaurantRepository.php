<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }
    function SearchByRegion($nsc)

    {
        return $this->createQueryBuilder('o')
            ->where ('o.idRegion = :idRegion')
            ->setParameter('idRegion',$nsc)
            ->getQuery()->getResult();
        ;

    }

    function SearchNom($nsc)

    {
        return $this->createQueryBuilder('o')
            ->where ('o.nom_resto LIKE :nom_restaurant')
            ->setParameter('nom_restaurant','%'.$nsc.'%')
            ->getQuery()->getResult();
        ;

    }

    public function findEntitiesByString($str)
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Restaurant p
            WHERE p.nom_resto LIKE :str'

        )->setParameter('str', $str);

        // returns an array of Product objects
        return $query->getResult();
    }

    function tri_asc()
    {
        return $this->createQueryBuilder('restaurant')
            ->orderBy('restaurant.nom_resto ','ASC')
            ->getQuery()->getResult();
    }
    function tri_desc()
    {
        return $this->createQueryBuilder('restaurant')
            ->orderBy('restaurant.nom_resto ','DESC')
            ->getQuery()->getResult();
    }

    // /**
    //  * @return Restaurant[] Returns an array of Restaurant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Restaurant
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
}