<?php

namespace App\Repository;

use App\Entity\ImageGite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageGite|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageGite|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageGite[]    findAll()
 * @method ImageGite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageGiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageGite::class);
    }

    // /**
    //  * @return ImageGite[] Returns an array of ImageGite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageGite
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
