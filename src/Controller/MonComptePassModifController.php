<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonComptePassModifController extends AbstractController
{
    /**
     * @Route("/mon/compte/pass/modif", name="app_mon_compte_pass_modif")
     */
    public function index(): Response
    {
        return $this->render('mon_compte_pass_modif/index.html.twig', [
            'controller_name' => 'MonComptePassModifController',
        ]);
    }
}
