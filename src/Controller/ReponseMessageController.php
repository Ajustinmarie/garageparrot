<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Horaires;
use App\Entity\MessageContact;
use App\Form\MessageContactType;
use App\Form\VisuReponseMessageType;

class ReponseMessageController extends AbstractController
{


    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

        /**
         * @Route("/reponse/message", name="reponse_message")
         */
        public function index(): Response
        {
            $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();
            $message_contacts=$this->entityManager->getRepository(MessageContact::class)->recherchestatus();
            return $this->render('message_contact/reponse_message.html.twig', [
                'horaires'=>$horaires,
                'message_contacts'=>$message_contacts
            ]);
        }


        /**
         * @Route("/reponse/message/supprimer/{id}", name="messagesupprimer")
         */
        public function delete($id): Response
        {
          $message_contacts=$this->entityManager->getRepository(MessageContact::class)->delete($id);
          return $this->redirectToRoute('reponse_message');
        }


          /**
         * @Route("/reponse/message/reponse/{id}", name="messagereponse")
         */
        public function reponsemessage($id): Response
        {
        
        $message_contacts=$this->entityManager->getRepository(MessageContact::class)->findOneByid($id);
        
           if(!$message_contacts)
        {
         return $this->redirectToRoute('reponse_message');
        }


        $messagecontact=new MessageContact();
      
       // $message_contacts->getnom()

     
       $nom=$message_contacts->getnom();
       $prenom=$message_contacts->getprenom();
       $sujet=$message_contacts->getsujet();
       $message=$message_contacts->getmessage();
       $numero=$message_contacts->getnumero();
       $mail=$message_contacts->getemail();


       $messagecontact->setnom($nom);
       $messagecontact->setprenom($prenom);
       $messagecontact->setsujet($sujet);
       $messagecontact->setmessage($message);
       $messagecontact->setnumero($numero);
       $messagecontact->setemail($mail);

    






        $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();
       
         
         $form=$this->createForm(VisuReponseMessageType::class, $messagecontact);
         // return $this->redirectToRoute('reponse_message');
         // dd($message_contacts);

        

         return $this->render('message_contact/voir_message.html.twig', [
            'horaires'=>$horaires,
            'message_contacts'=>$message_contacts,
            'form'=>$form->createView(),
        ]);
        }



}
