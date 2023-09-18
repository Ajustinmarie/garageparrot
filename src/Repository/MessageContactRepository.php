<?php

namespace App\Repository;

use App\Entity\MessageContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MessageContact>
 *
 * @method MessageContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageContact[]    findAll()
 * @method MessageContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageContact::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(MessageContact $entity, bool $flush = true): void
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
    public function remove(MessageContact $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

            /***********************LISTING DES MESSAGES  ******************************************/
 
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


            public function delete($id): array
            {
                    $conn = $this->getEntityManager()->getConnection();
                    $sql = "DELETE FROM message_contact  WHERE id=$id ";      
                
                    $stmt = $conn->prepare($sql);
                    $resultSet = $stmt->executeQuery();
                    // returns an array of arrays (i.e. a raw data set)
                    return $resultSet->fetchAllAssociative();
            }

                /******************** ****************************************/
public function recherchestatus(): array
{
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM message_contact WHERE status IS NULL ";        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
}


            

    // /**
    //  * @return MessageContact[] Returns an array of MessageContact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessageContact
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
