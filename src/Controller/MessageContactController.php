<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Horaires;
use App\Entity\MessageContact;
use App\Form\MessageContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MessageContactController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }


    /**
     * @Route("/message/contact", name="message_contact")
     */
    public function index(Request $request): Response
    {
        $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();

        $messagecontact=new MessageContact();
        $form=$this->createForm(MessageContactType::class, $messagecontact);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()) 
            {
                $this->entityManager->persist($messagecontact);
                $this->entityManager->flush();
                return $this->redirectToRoute('message_contact');
            }

        return $this->render('message_contact/index.html.twig', [
               'horaires'=>$horaires,
               'form'=>$form->createView()
        ]);
    }
}
