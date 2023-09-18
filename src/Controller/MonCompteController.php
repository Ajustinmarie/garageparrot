<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FormulaireUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Horaires;

class MonCompteController extends AbstractController
{



    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }


    /**
     * @Route("/mon_compte", name="mon_compte")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {

        $user=new User();
        $form=$this->createForm(FormulaireUserType::class,$user);
        $form->handleRequest($request);
        $notification=null;     

         $utilisateurs=$this->entityManager->getRepository(User::class)->findAll();

       //  dd($utilisateurs);

       $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();


        if($form->isSubmitted() and $form->isValid())
        {
            //dd($form->getData());
            $user=$form->getData();
            $password=$user->getPassword();
            $user_crypt_password=$encoder->encodePassword($user,$password);    
            $user->setPassword($user_crypt_password);         
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $notification='Le compte à bien été crée';
    
    
        };        


        return $this->render('security/moncompte.html.twig', [
                 'form'=>$form->createView(),
                 'notification'=>$notification,
                 'utilisateurs'=>$utilisateurs,
                 'horaires'=>$horaires
        ]);
    }



     /**
     * @Route("/mon_compte_supp_user/{id}", name="supp_user")
     */
    public function delete($id): Response
    {
      //  dd($id);
        $utilisateurs=$this->entityManager->getRepository(User::class)->delete($id);
       // $utilisateurs->flush();
       // return $this->render('cart/index.html.twig');
        return $this->redirectToRoute('mon_compte');
   
    }
}
