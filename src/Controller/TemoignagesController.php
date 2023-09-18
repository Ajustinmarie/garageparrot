<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Horaires;
use App\Entity\Temoignages;
use App\Form\TemoignagesType;
use Symfony\Component\HttpFoundation\Request;

class TemoignagesController extends AbstractController
{


    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }


    /**
     * @Route("/temoignages", name="temoignages")
     */
    public function index(Request $request): Response
    {   
                $notification=null;   
                $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();
                $temoignages=new Temoignages();
                $form=$this->createForm(TemoignagesType::class, $temoignages);
                $form->handleRequest($request);

              

             //   dd($temoignages);


                if($form->isSubmitted() and $form->isValid()) 
                    {
                        $this->entityManager->persist($temoignages);
                        $this->entityManager->flush();
                        $notification='Votre témoignage va etre soumis en approbation avant d\'etre posté';   
                    }

                      /* Liste des temoignages */
                $temoignages=$this->entityManager->getRepository(Temoignages::class)->SelectionCondition();

                return $this->render('temoignages/index.html.twig', [
                    'form'=>$form->createView(),
                    'horaires'=>$horaires,
                    'notification'=>$notification,
                    'temoignages'=>$temoignages
                ]);
    }
}
