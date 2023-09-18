<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Horaires;
use App\Entity\Voitures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AjouterUneVoitureController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    


    /**
     * @Route("/ajouter/une/voiture", name="ajouter_une_voiture")
     */
    public function index(Request $request): Response
    {        
              $notification=null;
              $notification2=null;
        
            if ($request->isMethod('POST')) 
            {
                                $nomdevoiture=$request->request->get('nom_voiture');
                                $prix=$request->request->get('prix');
                                $anneecirculation=$request->request->get('annee_circulation');
                                $kilometrage=$request->request->get('kilometrage');
                                $contact=$request->request->get('contact');
                                $moteur=$request->request->get('moteur');
                                $transmission=$request->request->get('transmission');
                                $carrosserie=$request->request->get('carrosserie');

                                $image1= $request->files->get('image1');
                                $image2= $request->files->get('image2');
                                $image3= $request->files->get('image3');
                                $image4= $request->files->get('image4');


                                if(!empty($nomdevoiture) AND !empty($prix)  AND  !empty($anneecirculation) AND !empty($kilometrage) AND !empty($contact) AND !empty($moteur) AND !empty($transmission) AND !empty($carrosserie))
                                {  
                                                        $taille_autorise = 2000000000;
                                                        /*****************************IMAGE 1*****************************/                                                       
                                                        $taille=$image1['size'];
                                                        $nom_fichier1 = $image1['name'];
                                                        $dossierTempo1 = $image1['tmp_name']; 
                                                        /*****************************IMAGE 2*****************************/
                                                        $taille2=$image2['size'];
                                                        $nom_fichier2 = $image2['name'];
                                                        $dossierTempo2 = $image2['tmp_name'];
                                                         /*****************************IMAGE 3*****************************/
                                                        $taille3=$image3['size'];
                                                        $nom_fichier3 = $image3['name'];
                                                        $dossierTempo3 = $image3['tmp_name'];
                                                          /*****************************IMAGE 4*****************************/
                                                          $taille4=$image4['size'];
                                                          $nom_fichier4 = $image4['name'];
                                                          $dossierTempo4 = $image4['tmp_name'];

                                                        /*****************************IMAGE 1*****************************/
                                                        $extension = strchr($nom_fichier1,'.');
                                                        /*****************************IMAGE 2*****************************/
                                                        $extension2 = strchr($nom_fichier2,'.');
                                                        /*****************************IMAGE 3*****************************/
                                                        $extension3 = strchr($nom_fichier3,'.');
                                                         /*****************************IMAGE 4*****************************/
                                                        $extension4 = strchr($nom_fichier4,'.');

                                                        $extension_autoriser = array('.png','.PNG','.jpg','.JPG','');


                                                         /*****************************IMAGE 1*****************************/
                                                        $nouveauNom1 = time();
                                                        $nouveauNom1 = '1-'.$nouveauNom1.$extension;
                                                        $dossierReception1 = 'upload/'.$nouveauNom1;                                                        
                                                         /*****************************IMAGE 2*****************************/
                                                        $nouveauNom2 = time();
                                                        $nouveauNom2 = '2-'.$nouveauNom2.$extension2;
                                                        $dossierReception2 = 'upload/'.$nouveauNom2;                                                        
                                                         /*****************************IMAGE 3*****************************/
                                                        $nouveauNom3 = time();
                                                        $nouveauNom3 = '3-'.$nouveauNom2.$extension3;
                                                        $dossierReception3 = 'upload/'.$nouveauNom3;
                                                            /*****************************IMAGE 4*****************************/
                                                        $nouveauNom4 = time();
                                                        $nouveauNom4 = '4-'.$nouveauNom4.$extension4;
                                                        $dossierReception4 = 'upload/'.$nouveauNom4;

                                                        if(!in_array($extension, $extension_autoriser) OR !in_array($extension2, $extension_autoriser) OR !in_array($extension3, $extension_autoriser) OR !in_array($extension4, $extension_autoriser) )
                                                        {
                                                            // echo'Extension Non autorisé!'; 
                                                            $notification2='Extension Non autorisé!';   
                                                        }
                                                        elseif ($taille>$taille_autorise OR $taille2>$taille_autorise OR $taille3>$taille_autorise OR $taille4>$taille_autorise)
                                                        {      
                                                            // echo 'Le fichier est trop volumineux!'; 
                                                            $notification2='Les fichiers sont trop volumineux!';        
                                                        }
                                                        else
                                                        {
                                                                        $testdeplacer= move_uploaded_file($dossierTempo1, $dossierReception1);
                                                                        $testdeplacer2= move_uploaded_file($dossierTempo2, $dossierReception2);
                                                                        $testdeplacer3= move_uploaded_file($dossierTempo3, $dossierReception3);
                                                                        $testdeplacer4= move_uploaded_file($dossierTempo4, $dossierReception4);                                                                      

                                                                        
                                                                        $insertion_voiture=$this->entityManager->getRepository(Voitures::class)->insertion($nomdevoiture, $prix, $anneecirculation, $kilometrage, $contact, $nouveauNom1,$nouveauNom2,$nouveauNom3, $nouveauNom4, $moteur, $transmission, $carrosserie);
                                                                        $notification='Votre voiture a bien été enregistré';
                                                        }
                                                    /*****************************IMAGE 2*****************************/

                                }    
                                else
                                {
                                      $notification='Votre voiture n\'a pas pu etre bien enregistré';
                                }             
            }      

           $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();
           $liste_des_voitures=$this->entityManager->getRepository(Voitures::class)->findAll();  
           
        

            return $this->render('ajouter_une_voiture/index.html.twig', [
                'controller_name' => 'AjouterUneVoitureController',
                'horaires'=>$horaires,
                'notification'=>$notification,
                'notification2'=>$notification2,
                'liste_des_voitures'=>$liste_des_voitures,
               
            ]);
    }
    

        /******************************** FONCTION SUPPRIMER ****************************************/

      /**
     * @Route("/supprimer/une/voiture/{id}", name="supprimer_une_voiture")
     */
    public function delete($id): Response
    {
             $this->entityManager->getRepository(Voitures::class)->delete($id);
             return $this->redirectToRoute('ajouter_une_voiture');
    }


    
    /******************************** FONCTION MODIFIER UNE VOITURE ****************************************/
      /**
     * @Route("/modifier/une/voiture/{id}", name="modifier_une_voiture")
     */
    public function modifier($id, Request $request): Response
    {
        $notification=null;
        $notification2=null;
        $voiture=$this->entityManager->getRepository(Voitures::class)->findOneByid($id);
  
      if ($request->isMethod('POST')) 
      {
                          $nomdevoiture=$request->request->get('nom_voiture');
                          $prix=$request->request->get('prix');
                          $anneecirculation=$request->request->get('annee_circulation');
                          $kilometrage=$request->request->get('kilometrage');
                          $contact=$request->request->get('contact');
                          $moteur=$request->request->get('moteur');
                          $transmission=$request->request->get('transmission');
                          $carrosserie=$request->request->get('carrosserie');
                          

                          $image1= $request->files->get('image1');
                          $image2= $request->files->get('image2');
                          $image3= $request->files->get('image3');
                          $image4= $request->files->get('image4');
                          


                          if(!empty($nomdevoiture) AND !empty($prix)  AND  !empty($anneecirculation) AND !empty($kilometrage) AND !empty($contact) AND !empty($moteur) AND !empty($transmission) AND !empty($carrosserie))
                          {  
                                                  $taille_autorise = 2000000000;
                                                  /*****************************IMAGE 1*****************************/                                                       
                                                  $taille=$image1['size'];
                                                  $nom_fichier1 = $image1['name'];
                                                  $dossierTempo1 = $image1['tmp_name']; 
                                                  /*****************************IMAGE 2*****************************/
                                                  $taille2=$image2['size'];
                                                  $nom_fichier2 = $image2['name'];
                                                  $dossierTempo2 = $image2['tmp_name'];
                                                   /*****************************IMAGE 3*****************************/
                                                  $taille3=$image3['size'];
                                                  $nom_fichier3 = $image3['name'];
                                                  $dossierTempo3 = $image3['tmp_name'];
                                                    /*****************************IMAGE 4*****************************/
                                                    $taille4=$image4['size'];
                                                    $nom_fichier4 = $image4['name'];
                                                    $dossierTempo4 = $image4['tmp_name'];
                                        
                                               

                                        if($dossierTempo1!='' OR $dossierTempo2!='' OR $dossierTempo3!='' OR $dossierTempo4!='')
                                        {
                                      
                                                       
                                                                /*****************************IMAGE 1*****************************/
                                                                $extension = strchr($nom_fichier1,'.');
                                                                /*****************************IMAGE 2*****************************/
                                                                $extension2 = strchr($nom_fichier2,'.');
                                                                /*****************************IMAGE 3*****************************/
                                                                $extension3 = strchr($nom_fichier3,'.');
                                                                /*****************************IMAGE 4*****************************/
                                                                $extension4 = strchr($nom_fichier4,'.');

                                                                $extension_autoriser = array('.png','.PNG','.jpg','.JPG','');

                                                                /*****************************IMAGE 1*****************************/
                                                                $nouveauNom1 = time();
                                                                $nouveauNom1 = '1-'.$nouveauNom1.$extension;
                                                                $dossierReception1 = 'upload/'.$nouveauNom1;                                                        
                                                                /*****************************IMAGE 2*****************************/
                                                                $nouveauNom2 = time();
                                                                $nouveauNom2 = '2-'.$nouveauNom2.$extension2;
                                                                $dossierReception2 = 'upload/'.$nouveauNom2;                                                        
                                                                /*****************************IMAGE 3*****************************/
                                                                $nouveauNom3 = time();
                                                                $nouveauNom3 = '3-'.$nouveauNom2.$extension3;
                                                                $dossierReception3 = 'upload/'.$nouveauNom3;
                                                                    /*****************************IMAGE 4*****************************/
                                                                $nouveauNom4 = time();
                                                                $nouveauNom4 = '4-'.$nouveauNom4.$extension4;
                                                                $dossierReception4 = 'upload/'.$nouveauNom4;

                                                                                                             

                                                                
                                                                if(!in_array($extension4, $extension_autoriser) OR !in_array($extension3, $extension_autoriser) OR !in_array($extension2, $extension_autoriser) OR !in_array($extension, $extension_autoriser))
                                                                {
                                                                    // echo'Extension Non autorisé!'; 
                                                                    $notification2='Extension Non autorisé!';   
                                                                }
                                                                elseif ($taille>$taille_autorise OR $taille2>$taille_autorise OR $taille3>$taille_autorise OR $taille4>$taille_autorise)
                                                                {      
                                                                    // echo 'Le fichier est trop volumineux!'; 
                                                                    $notification2='Les fichiers sont trop volumineux!';        
                                                                }
                                                                else
                                                                {
                                                                          
                                                                                    $testdeplacer= move_uploaded_file($dossierTempo1, $dossierReception1);
                                                                                    $testdeplacer2= move_uploaded_file($dossierTempo2, $dossierReception2);
                                                                                    $testdeplacer3= move_uploaded_file($dossierTempo3, $dossierReception3);
                                                                                    $testdeplacer4= move_uploaded_file($dossierTempo4, $dossierReception4); 

                                                                                    if($testdeplacer)
                                                                                    {
                                                                                              $this->entityManager->getRepository(Voitures::class)->upgrade2($nouveauNom1, $id);
                                                                                    }

                                                                                    if($testdeplacer2)
                                                                                    {
                                                                                              $this->entityManager->getRepository(Voitures::class)->upgrade3($nouveauNom2, $id);
                                                                                    }

                                                                                    if($testdeplacer3)
                                                                                    {
                                                                                              $this->entityManager->getRepository(Voitures::class)->upgrade4($nouveauNom3, $id);
                                                                                    }

                                                                                    if($testdeplacer4)
                                                                                    {
                                                                                             $this->entityManager->getRepository(Voitures::class)->upgrade5($nouveauNom4, $id);
                                                                                    }

                                                                           // dd('juj');
                                                                                    $updatevoiture=$this->entityManager->getRepository(Voitures::class)->upgrade($nomdevoiture, $prix, $id, $anneecirculation, $kilometrage, $contact, $moteur, $transmission, $carrosserie);

                                                                                //   $updatevoiture=$this->entityManager->getRepository(Voitures::class)->upgrade2($nomdevoiture, $prix, $id, $anneecirculation, $kilometrage, $contact, $nouveauNom1, $nouveauNom2, $nouveauNom3, $nouveauNom4);                                                                               
                                                                                    $notification='les données de votre voiture ont été mis à jour';
                                                                                //   return $this->redirectToRoute('ajouter_une_voiture');
                                                                }
                                                              
                                                            
                                       }
                                          else
                                          {
                                                        $updatevoiture=$this->entityManager->getRepository(Voitures::class)->upgrade($nomdevoiture, $prix, $id, $anneecirculation, $kilometrage, $contact, $moteur, $transmission, $carrosserie);
                                                        $notification='les données de votre voiture ont été mis à jour';
                                                    //    return $this->redirectToRoute('ajouter_une_voiture');
                                          }
                          }    
                          else
                          {
                                $notification='Votre voiture na pas pu etre bien enregistré';
                          }             
      } 
      
     $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();
     $liste_des_voitures=$this->entityManager->getRepository(Voitures::class)->findAll();    
     
     $voiture=$this->entityManager->getRepository(Voitures::class)->findOneByid($id);
    
      return $this->render('ajouter_une_voiture/index.html.twig', [
          'controller_name' => 'AjouterUneVoitureController',
          'horaires'=>$horaires,
          'notification'=>$notification,
          'notification2'=>$notification2,
          'liste_des_voitures'=>$liste_des_voitures,
          'voiture'=>$voiture
      ]);
    }

    


}
