<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VentesDetailsController extends AbstractController
{
    /**
     * @Route("/ventes/details", name="ventes_details")
     */
    public function index(): Response
    {
        return $this->render('ventes/ventes_details.html.twig', [
            'controller_name' => 'VentesDetailsController',
        ]);
    }
}
                                     