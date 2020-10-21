<?php

namespace App\Repository;

use App\Entity\Quotes;
use App\Entity\Categories;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\AST\Functions\ConcatFunction;

/**
 * @method Quotes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quotes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quotes[]    findAll()
 * @method Quotes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quotes::class);
    }

    /**
     * @return Quotes[] Returns an array of Quotes objects
    */
    public function findAllArray() : array
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.date', 'DESC');

        $query = $qb->getQuery();

        return $query->execute();
    }
    

    /**
     * @return Quotes[] Returns an array of Quotes objects
    */
    public function apiFindAll() : array
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a.id', 'a.strQuote', 'a.rating', 'a.date')
            ->orderBy('a.date', 'DESC');

        $query = $qb->getQuery();

        return $query->execute();
    }


    // /**
    //  * @return Articles[] Returns an array of Articles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Articles
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
