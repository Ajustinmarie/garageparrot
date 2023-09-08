<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspaceemployerController extends AbstractController
{
    /**
     * @Route("/espaceemployer", name="espaceemployer")
     */
    public function index(): Response
    {
        return $this->render('security/espace_employe.html.twig', [
            'controller_name' => 'EspaceemployerController',
        ]);
    }
}
