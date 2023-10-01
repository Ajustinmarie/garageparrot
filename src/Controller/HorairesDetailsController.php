<?php

namespace App\Controller;

use App\Entity\Horaires;
use App\Entity\ServiceRepertoire;
use App\Form\HorairesProgrammeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class HorairesDetailsController extends AbstractController
{
     
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    /**
     * @Route("/horaires/details", name="horaires_details")
     */
    public function index(Request $request): Response
    {

        $horaires=new Horaires();
        $form=$this->createForm(HorairesProgrammeType::class, $horaires);
        $form->handleRequest($request);


if($form->isSubmitted() and $form->isValid()) 
{
    $this->entityManager->persist($horaires);
    $this->entityManager->flush();
}

$horaires=$this->entityManager->getRepository(Horaires::class)->findAll();

// dd($horaires);

        return $this->render('horaires_details/index.html.twig', [
            'form'=>$form->createView(),
            'horaires'=>$horaires
        ]);
    }


    /******************************** FONCTION SUPPRIMER ****************************************/

      /**
     * @Route("/horaires/suppression/{id}", name="horaires_suppression")
     */
    public function delete($id): Response
    {
             $horaires=$this->entityManager->getRepository(Horaires::class)->delete($id);
             return $this->redirectToRoute('horaires_details');
    }



        /******************************** FONCTION UPDATE ****************************************/

      /**
     * @Route("/horaires/update/{id}", name="horaires_update")
     */
    public function update(Request $request, $id): Response
    {

       $horaire_update=$this->entityManager->getRepository(Horaires::class)->find($id);
     //  dd($horaire_update->getJour());
     
     
          if(!$horaire_update)
     {
      return $this->redirectToRoute('horaires_details');
     }

        $jour=$horaire_update->getJour();
        $programme=$horaire_update->getProgramme();

        $horaires=new Horaires();

        $horaires->setJour($jour);
        $horaires->setProgramme($programme);
    //    dd($horaires);

        $form=$this->createForm(HorairesProgrammeType::class, $horaires);
        $form->handleRequest($request);


if($form->isSubmitted() and $form->isValid()) 
{
  $jour_finale=$form->getData()->getJour();   
  $programme_finale=$form->getData()->getProgramme();   

  $upgrade_horaire=$this->entityManager->getRepository(Horaires::class)->upgrade2($jour_finale, $programme_finale, $id);   

  return $this->redirectToRoute('horaires_details');  

  //  dd($form->getData()->getProgramme());
  //  $this->entityManager->persist($horaires);
  //  $this->entityManager->flush();
}

$horaires=$this->entityManager->getRepository(Horaires::class)->findAll();

// dd($horaires);

        return $this->render('horaires_details/index.html.twig', [
            'form'=>$form->createView(),
            'horaires'=>$horaires
        ]);
    }
}
