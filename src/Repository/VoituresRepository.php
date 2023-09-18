<?php

namespace App\Repository;

use App\Entity\Voitures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Voitures>
 *
 * @method Voitures|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voitures|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voitures[]    findAll()
 * @method Voitures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoituresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voitures::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Voitures $entity, bool $flush = true): void
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
    public function remove(Voitures $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    /************************INSERER UNE VOITURE******************************************/
    public function insertion($nomdevoiture, $prix, $anneecirculation, $kilometrage, $contact, $nouveauNom1, $nouveauNom2, $nouveauNom3, $nouveauNom4, $moteur, $transmission, $carrosserie): array
    {
            $conn = $this->getEntityManager()->getConnection();
            $sql = "INSERT INTO voitures (nom, prix, anneecirculation, kilometrage, contact, image1, image2, image3, image4, moteur, transmission, carrosserie) VALUES ('$nomdevoiture', '$prix', '$anneecirculation','$kilometrage', '$contact','$nouveauNom1', '$nouveauNom2','$nouveauNom3','$nouveauNom4','$moteur','$transmission','$carrosserie')";  
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
    }


    /***********************SUPPRIMER UNE VOITURE******************************************/     
    public function delete($id): array
    {
            $conn = $this->getEntityManager()->getConnection();
            $sql = "DELETE FROM voitures WHERE id=$id ";         
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
    }


        /***********************MODIFIER VOITURE***********************************************/ 
        public function upgrade($nomdevoiture, $prix, $id, $anneecirculation, $kilometrage, $contact, $moteur, $transmission, $carrosserie): array
        {
                $conn = $this->getEntityManager()->getConnection();
                $sql = "UPDATE voitures SET 
                nom='$nomdevoiture', 
                prix='$prix',
                anneecirculation='$anneecirculation',
                kilometrage='$kilometrage',
                contact='$contact',
                moteur='$moteur',
                transmission='$transmission',
                carrosserie='$carrosserie'
                WHERE id='$id'";        
                $stmt = $conn->prepare($sql);
                $resultSet = $stmt->executeQuery();
                // returns an array of arrays (i.e. a raw data set)
                return $resultSet->fetchAllAssociative();
        }


        public function upgrade2($nouveauNom1, $id): array
        {       


                $conn = $this->getEntityManager()->getConnection();
                $sql = "UPDATE voitures SET 
                image1='$nouveauNom1'
                WHERE id='$id'";        
                $stmt = $conn->prepare($sql);
                $resultSet = $stmt->executeQuery();
                // returns an array of arrays (i.e. a raw data set)
                return $resultSet->fetchAllAssociative();
        }

        public function upgrade3($nouveauNom2, $id): array
        {  
            $conn = $this->getEntityManager()->getConnection();
            $sql = "UPDATE voitures SET 
            image2='$nouveauNom2'
            WHERE id='$id'";        
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
        }

        public function upgrade4($nouveauNom3, $id): array
        {  
            $conn = $this->getEntityManager()->getConnection();
            $sql = "UPDATE voitures SET 
            image3='$nouveauNom3'
            WHERE id='$id'";        
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
        }

        public function upgrade5($nouveauNom4, $id): array
        {  
            $conn = $this->getEntityManager()->getConnection();
            $sql = "UPDATE voitures SET 
            image4='$nouveauNom4'
            WHERE id='$id'";        
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            // returns an array of arrays (i.e. a raw data set)
            return $resultSet->fetchAllAssociative();
        }


        public function rechercher($prixMinimun,  $prixMaximun, $kmparcouruMin, $kmparcouruMax, $annecirculationmin, $annecirculationmax){
            $conn = $this->getEntityManager()->getConnection();

           

            

        
            // Cas pour le filtre kmParcouru
    if (!empty($kmparcouruMin) && !empty($kmparcouruMax)) {
        $cas2 = ' AND kilometrage BETWEEN :kmparcouruMin AND :kmparcouruMax';
    } elseif (!empty($kmparcouruMin) AND empty($kmparcouruMax) ) {
        $cas2 = ' AND kilometrage >= :kmparcouruMin';
    } elseif (!empty($kmparcouruMax) AND empty($kmparcouruMin) ) {
        $cas2 = ' AND kilometrage <= :kmparcouruMax';
    }else{
        $cas2='';
    }

              // Cas pour le filtre kmParcouru
              if (!empty($annecirculationmin) && !empty($annecirculationmax)) {
                $cas3 = ' AND anneecirculation BETWEEN :annecirculationmin AND :annecirculationmax';
            } elseif (!empty($annecirculationmin) AND empty($annecirculationmax) ) {
                $cas3 = ' AND anneecirculation >= :annecirculationmin';
            } elseif (!empty($annecirculationmax) AND empty($kmparcouruMin) ) {
                $cas3 = ' AND anneecirculation <= :annecirculationmax';
            }else{
                $cas3='';
            }



    $sql = 'SELECT * FROM voitures WHERE prix 
    BETWEEN :prixMinimun AND :prixMaximun 
    '.$cas3.'
    '.$cas2.'
    ';       
    $stmt = $conn->prepare($sql);
 
     
   

          
            


          

             $stmt->bindValue(':prixMinimun', $prixMinimun, \PDO::PARAM_INT);
             $stmt->bindValue(':prixMaximun', $prixMaximun, \PDO::PARAM_INT);

             if($kmparcouruMin)
             {
                $stmt->bindValue(':kmparcouruMin', $kmparcouruMin, \PDO::PARAM_INT);     
             }

             if($kmparcouruMax)
             {
                $stmt->bindValue(':kmparcouruMax', $kmparcouruMax, \PDO::PARAM_INT);
             }
                
             if($annecirculationmin)
             {
                $stmt->bindValue(':annecirculationmin', $annecirculationmin, \PDO::PARAM_INT);
             }

             if($annecirculationmax)
             {
                $stmt->bindValue(':annecirculationmax', $annecirculationmax, \PDO::PARAM_INT);
             }
           

         
           


            $resultSet = $stmt->executeQuery();
        
            return $resultSet->fetchAllAssociative();       
         }
                // /**
                //  * @return Voitures[] Returns an array of Voitures objects
                //  */
                /*
                public function findByExampleField($value)
                {
                    return $this->createQueryBuilder('v')
                        ->andWhere('v.exampleField = :val')
                        ->setParameter('val', $value)
                        ->orderBy('v.id', 'ASC')
                        ->setMaxResults(10)
                        ->getQuery()
                        ->getResult()
                    ;
                }
                */

                /*
                public function findOneBySomeField($value): ?Voitures
                {
                    return $this->createQueryBuilder('v')
                        ->andWhere('v.exampleField = :val')
                        ->setParameter('val', $value)
                        ->getQuery()
                        ->getOneOrNullResult()
                    ;
                }
                */
}
