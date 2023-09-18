<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Horaires;
use App\Entity\Voitures;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\MessageContactType;
use App\Entity\MessageContact;
use Symfony\Component\HttpFoundation\Request;


class VentesDetailsController extends AbstractController
{
   
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    /**
     * @Route("/ventes/details/{id}", name="ventes_details")
     */
    public function index($id, Request $request): Response
    {
        $notification=null;

        $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();

        $voiture=$this->entityManager->getRepository(Voitures::class)->findOneByid($id);
       

        $identifiant=$voiture->getid();
        $sujetnom=$voiture->getnom();
        $sujet=$sujet = "Identifiant de l'annonce: $identifiant || Nom de l'annonce: $sujetnom";

     

        $messagecontact=new MessageContact();
        $messagecontact->setSujet($sujet);
        $messagecontact->getSujet();

   
    //   dd($messagecontact);

      

        $form=$this->createForm(MessageContactType::class, $messagecontact);
        $form->handleRequest($request);




        if($form->isSubmitted() and $form->isValid()) 
        {
           
             $this->entityManager->persist($messagecontact);
              $this->entityManager->flush();
              $notification='Message envoyé';
             return $this->redirectToRoute('message_contact');
        }


        return $this->render('ventes/ventes_details.html.twig', [
            'controller_name' => 'VentesDetailsController',
            'horaires'=>$horaires,
            'voiture'=>$voiture,
            'notification'=>$notification,
            'form'=>$form->createView()
        ]);
    }
}
                                     