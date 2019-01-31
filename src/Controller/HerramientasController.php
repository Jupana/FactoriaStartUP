<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HerramientasController extends AbstractController
{
    /**
     * @Route("/herramientas", name="herramientas")
     */
    public function index()
    {
        return $this->render('herramientas/index.html.twig', [
            'controller_name' => 'HerramientasController',
        ]);
    }
}
