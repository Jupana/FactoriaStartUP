<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProyectosController extends AbstractController
{
    /**
     * @Route("/proyectos", name="proyectos")
     */
    public function index()
    {
        return $this->render('proyectos/index.html.twig', [
            'controller_name' => 'ProyectosController',
        ]);
    }
}
