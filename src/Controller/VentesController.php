<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Horaires;
use App\Entity\Voitures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class VentesController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    /**
     * @Route("/ventes", name="ventes")
     */
    public function index(Request $request): Response
    {
         $voituretries=null;
         $post=null;
         $prixMinimun=null;
         $prixMaximun=null;
         $kmparcouruMin=null;
         $kmparcouruMax=null;
         $annecirculationmin=null;
         $annecirculationmax=null;
         $notification=null;




        $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();
        $voituresventes=$this->entityManager->getRepository(Voitures::class)->findAll();
        //dd($voituresventes);

        if ($request->isMethod('POST')) 
          {
                  
            
              
                  $prixMinimun= $request->get('prixmin'); 
                  $prixMaximun= $request->get('prixMax'); 
                  $kmparcouruMin= $request->get('kmparcouruMin'); 
                  $kmparcouruMax= $request->get('kmparcouruMax'); 
                  $annecirculationmin= $request->get('annecirculationmin'); 
                  $annecirculationmax= $request->get('annecirculationmax'); 
                  $post='definit';


                  if(empty($prixMinimun) AND empty($prixMaximun))
                  {
                      $notification='Veuillez renseigner obligatoirement une fourchette de prix minimun et maximun';
                  }
                  else
                  {
                      $voituretries=$this->entityManager->getRepository(Voitures::class)->rechercher($prixMinimun,  $prixMaximun, $kmparcouruMin, $kmparcouruMax, $annecirculationmin, $annecirculationmax);
                  }
                

                 
                 
                 
                 
          }

        
        return $this->render('ventes/index.html.twig', [
            'controller_name' => 'VentesController',
            'horaires'=>$horaires,
            'voituresventes'=>$voituresventes,
            'post'=>$post,
            'voituretries'=>$voituretries,
             'prixMinimun'=>$prixMinimun,
             'prixMaximun'=>$prixMaximun,
             'kmparcouruMin'=>$kmparcouruMin,
             'kmparcouruMax'=>$kmparcouruMax,
             'annecirculationmax'=>$annecirculationmax,
             'annecirculationmin'=>$annecirculationmin,
             'notification'=>$notification
        ]);
    }
}
