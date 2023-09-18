<?php

namespace App\Repository;

use App\Entity\ServiceRepertoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceRepertoire>
 *
 * @method ServiceRepertoire|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceRepertoire|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceRepertoire[]    findAll()
 * @method ServiceRepertoire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepertoireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceRepertoire::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ServiceRepertoire $entity, bool $flush = true): void
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
    public function remove(ServiceRepertoire $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

/***********************INSERER UN SERVICE ******************************************/
    public function insertion($nom, $description, $nouveauNom ): array
    {
            $conn = $this->getEntityManager()->getConnection();
            $sql = "INSERT INTO service_repertoire (nom_service, image, description) VALUES ('$nom', '$nouveauNom', '$description')";  
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
    }


/***********************SUPPRIMER UN SERVICE ******************************************/
    public function delete($id): array
    {
            $conn = $this->getEntityManager()->getConnection();
            $sql = "DELETE FROM service_repertoire WHERE id=$id ";      
        
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
    }

    /***********************MODIFIER UN SERVICE UPGRADE ******************************************/
 
    public function upgrade($nom, $description, $nouveauNom, $id ): array
    {
            $conn = $this->getEntityManager()->getConnection();
            $sql = "UPDATE service_repertoire SET 
            nom_service='$nom', 
            image='$nouveauNom', 
            description='$description'
            WHERE id='$id'";        
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
    }


        /***********************MODIFIER UN SERVICE UPGRADE SANS MISE A JOUR IMAGE ******************************************/
 
        public function upgrade2($nom, $description, $id ): array
        {
                $conn = $this->getEntityManager()->getConnection();
                $sql = "UPDATE service_repertoire SET 
                nom_service='$nom', 
                description='$description'
                WHERE id='$id'";        
                $stmt = $conn->prepare($sql);
                $resultSet = $stmt->executeQuery();
                // returns an array of arrays (i.e. a raw data set)
                return $resultSet->fetchAllAssociative();
        }



    // /**
    //  * @return ServiceRepertoire[] Returns an array of ServiceRepertoire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServiceRepertoire
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
