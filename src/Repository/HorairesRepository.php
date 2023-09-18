<?php

namespace App\Repository;

use App\Entity\Horaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Horaires>
 *
 * @method Horaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Horaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Horaires[]    findAll()
 * @method Horaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HorairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Horaires::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Horaires $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Horaires $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }



    /***********************SUPPRIMER UN SERVICE ******************************************/
    public function delete($id): array
    {
            $conn = $this->getEntityManager()->getConnection();
            $sql = "DELETE FROM horaires  WHERE id=$id ";      
        
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
    }

        /***********************MODIFIER UN HORAIRE ******************************************/
 
        public function upgrade2($jour_finale, $programme_finale, $id): array
        {
                $conn = $this->getEntityManager()->getConnection();
                $sql = "UPDATE horaires SET 
                jour='$jour_finale', 
                programme='$programme_finale'
                WHERE id='$id'";        
                $stmt = $conn->prepare($sql);
                $resultSet = $stmt->executeQuery();
                // returns an array of arrays (i.e. a raw data set)
                return $resultSet->fetchAllAssociative();
        }

    // /**
    //  * @return Horaires[] Returns an array of Horaires objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Horaires
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
