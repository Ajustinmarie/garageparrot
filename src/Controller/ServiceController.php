<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\ServiceRepertoire;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Horaires;


class ServiceController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

      /******************************FONCTION INSERTION ****************************************************/

    /**
     * @Route("/service", name="service")
     */
    public function index(Request $request): Response
    { 
        $notification=null;
        $notification2=null;

if ($request->isMethod('POST')) 
{

            $nom=$request->request->get('nom');
            $description=$request->request->get('description');
            $image_service= $request->files->get('image_service');

           
          
          if(!empty($nom) AND !empty($description)  AND  !empty($image_service))
          {

                    $taille_autorise = 2000000000;
                    $taille=$image_service['size'];
                    $nom_fichier = $image_service['name'];
                    $dossierTempo = $image_service['tmp_name']; 

                                  $extension = strchr($nom_fichier,'.');
                                  $extension_autoriser = array('.png','.PNG','.jpg','.JPG','.pdf','.PDF');
                                  $nouveauNom = time();
                                  $nouveauNom = '1-'.$nouveauNom.$extension;
                                  $dossierReception = 'upload/'.$nouveauNom;

                                  if(!in_array($extension, $extension_autoriser))
                                  {
                                    // echo'Extension Non autorisé!'; 
                                    $notification2='Extension Non autorisé!';   
                                  }
                                  elseif ($taille>$taille_autorise)
                                  {      
                                      // echo 'Le fichier est trop volumineux!'; 
                                      $notification2='Le fichier est trop volumineux!';        
                                  }
                                  else
                                  {
                                                  $testdeplacer= move_uploaded_file($dossierTempo, $dossierReception);

                                                  if($testdeplacer)
                                                  {
                                                      // echo 'Fichier uploadé avec succès !';
                                                      $insertion_service=$this->entityManager->getRepository(ServiceRepertoire::class)->insertion($nom, $description, $nouveauNom );
                                                      $notification='Votre service a bien été enregistré';
                                                  }
                                                  else
                                                  {
                                                    //  echo 'Le fichier n\'a pas pu etre uploadé';
                                                      $notification='Votre service n\'a pas pu etre bien enregistré';
                                                  }
                                  }

                
          }
          else
          {
                $notification='Votre service n\'a pas pu etre bien enregistré';
          }
   
    
}
 

$horaires=$this->entityManager->getRepository(Horaires::class)->findAll();

 $services=$this->entityManager->getRepository(ServiceRepertoire::class)->findAll();

 if(empty($services))
{
  $services=null;
}

        return $this->render('service/index.html.twig', [
            'notification'=>$notification,
            'services'=>$services,
            'notification2'=>$notification2,
            'horaires'=>$horaires
        ]);
    }


  /******************************FONCTION SUPPRIMER ****************************************************/

      /**
     * @Route("/service_supprimer/{id}", name="service_supprimer")
     */
    public function delete($id): Response
    {

      $services=$this->entityManager->getRepository(ServiceRepertoire::class)->delete($id);

      return $this->redirectToRoute('service');
    }


      /******************************FONCTION MODIFIER UPGRADE ****************************************************/

          /**
     * @Route("/service_modifier/{id}", name="service_modifier")
     */
    public function modifier(Request $request, $id): Response
    { 
        $notification=null;
        $notification2=null;

if ($request->isMethod('POST')) 
{

    $nom=$request->request->get('nom');
    $description=$request->request->get('description');
    $image_service= $request->files->get('image_service');
    
             if(!empty($nom) AND !empty($description)  AND  !empty($image_service))
            {

                            $taille_autorise = 2000000000;
                            $taille=$image_service['size'];
                            $nom_fichier = $image_service['name'];
                            $dossierTempo = $image_service['tmp_name']; 

                            if($dossierTempo!='')
                            {
                             
                          
                                                $extension = strchr($nom_fichier,'.');
                                                $extension_autoriser = array('.png','.PNG','.jpg','.JPG','.pdf','.PDF');
                                                $nouveauNom = time();
                                                $nouveauNom = '1-'.$nouveauNom.$extension;
                                                $dossierReception = 'upload/'.$nouveauNom;    

                                                if(!in_array($extension, $extension_autoriser))
                                                {
                                                  // echo'Extension Non autorisé!'; 
                                                  $notification2='Extension Non autorisé!';   
                                                  
                                                }
                                                elseif ($taille>$taille_autorise)
                                                {      
                                                    // echo 'Le fichier est trop volumineux!';    
                                                    $notification2='Le fichier est trop volumineux!';   
                                                }
                                                else
                                                {
                                                        $testdeplacer= move_uploaded_file($dossierTempo, $dossierReception);
                                                        if($testdeplacer)
                                                        {
                                                            // echo 'Fichier uploadé avec succès !';
                                                          //  $insertion_service=$this->entityManager->getRepository(ServiceRepertoire::class)->insertion($nom, $description, $nouveauNom );               
                                                            /**********nouvel requete sql upgrade */
                                                         
                                                         
                                                                 $upgrade_service=$this->entityManager->getRepository(ServiceRepertoire::class)->upgrade($nom, $description, $nouveauNom, $id);
                                                         
                                                         
                                                                  $notification='Votre service a bien été mis à jour';
                                                        }
                                                        else
                                                        {
                                                          //  echo 'Le fichier n\'a pas pu etre uploadé';
                                                            $notification='Votre service n\'a pas pu etre mis à jour';
                                                        }
                                                }
                            }
                            else
                            {

                                       $upgrade_service=$this->entityManager->getRepository(ServiceRepertoire::class)->upgrade2($nom, $description, $id);                                                         
                                       $notification='Votre service a bien été mis à jour';

                                   

                            }

                  
            }
            else
            {
              $notification='Votre service n\'a pas pu etre enregistré 2';   
            }
   
    
}
 $service2s=$this->entityManager->getRepository(ServiceRepertoire::class)->find($id);

 $services=$this->entityManager->getRepository(ServiceRepertoire::class)->findAll();
// $services=$this->entityManager->getRepository(ServiceRepertoire::class)->findOneBy($id);
 // dd($services);

 $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();

        return $this->render('service/index.html.twig', [
            'notification'=>$notification,
            'service2s'=>$service2s,
            'services'=>$services,
            'notification2'=>$notification2,
            'horaires'=>$horaires
        ]);
    }




}
