<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Horaires;
use App\Entity\Temoignages;

class TemoignagesApprobationController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }


    /**
     * @Route("/temoignages/approbation", name="temoignages_approbation")
     */
    public function index(): Response
    {

        $horaires=$this->entityManager->getRepository(Horaires::class)->findAll();
        /* Liste des temoignages */
       $temoignages=$this->entityManager->getRepository(Temoignages::class)->SelectionApprouv();
        return $this->render('temoignages/approbation.html.twig', [
            'horaires'=>$horaires,
            'temoignages'=>$temoignages
        ]);
    }

      /**
     * @Route("/temoignages/approuver/{id}", name="temoignages_approuver")
     */
    public function show($id): Response
    {
        
      //  dd($id);
        $temoignages=$this->entityManager->getRepository(Temoignages::class)->UpgradeApprobation($id);
        return $this->redirectToRoute('temoignages_approbation');  

    }

          /**
     * @Route("/temoignages/suppression/{id}", name="temoignages_suppression")
     */
    public function delete($id): Response
    {
        
      //  dd($id);
        $temoignages=$this->entityManager->getRepository(Temoignages::class)->delete($id);
        return $this->redirectToRoute('temoignages_approbation');  

    }
}
