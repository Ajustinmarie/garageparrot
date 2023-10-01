<?php

namespace App\Repository;

use App\Entity\Temoignages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Temoignages>
 *
 * @method Temoignages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temoignages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temoignages[]    findAll()
 * @method Temoignages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemoignagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temoignages::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Temoignages $entity, bool $flush = true): void
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
    public function remove(Temoignages $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

/********************Liste des temoigngages ****************************************/
public function SelectionCondition(): array
{
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM temoignages WHERE status IS NOT NULL ";        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
}

/********************Liste des temoigngages LIMIT 3 ****************************************/
public function SelectionConditionLimit(): array
{
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM temoignages
        WHERE status IS NOT NULL
        ORDER BY ID DESC
        LIMIT 3;";        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
}



/********************Liste des temoigngages approuver ****************************************/
public function SelectionApprouv(): array
{
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM temoignages WHERE status IS NULL ";        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
}



    /***********************MODIFIER UN TEMOIGNAGE UPGRADE ******************************************/
 
    public function UpgradeApprobation($id): array
    {
            $conn = $this->getEntityManager()->getConnection();
            $sql = "UPDATE temoignages SET 
            status=1
            WHERE id='$id'";        
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
    }


    /***********************SUPPRIMER UN SERVICE ******************************************/
    public function delete($id): array
    {
            $conn = $this->getEntityManager()->getConnection();
            $sql = "DELETE FROM temoignages WHERE id=$id ";      
        
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
    }




    // /**
    //  * @return Temoignages[] Returns an array of Temoignages objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Temoignages
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
