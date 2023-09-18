<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Horaires;
use Doctrine\ORM\EntityManagerInterface;

class EspaceemployerController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }


    /**
     * @Route("/espaceemployer", name="espaceemployer")
     */
    public function index(): Response
    {

        $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();
     
        return $this->render('security/espace_employe.html.twig', [
            'controller_name' => 'EspaceemployerController',
            'horaires'=>$horaires
        ]);
    }
}
