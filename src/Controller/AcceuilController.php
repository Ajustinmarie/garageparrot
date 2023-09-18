<?php

namespace App\Controller;

use App\Entity\Horaires;
use App\Entity\ServiceRepertoire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Temoignages;

class AcceuilController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }



    /**
     * @Route("/", name="acceuil")
     */
    public function index(): Response
    {
        $services=$this->entityManager->getRepository(ServiceRepertoire::class)->findAll();
       //  dd($services);

       $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();

       $temoignages=$this->entityManager->getRepository(Temoignages::class)->SelectionConditionLimit();

        return $this->render('acceuil/index.html.twig', [
            'services' =>$services,
            'horaires'=>$horaires,
            'temoignages'=>$temoignages
        ]);
    }
}
