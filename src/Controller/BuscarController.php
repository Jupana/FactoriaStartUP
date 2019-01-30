<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BuscarController extends AbstractController
{
    /**
     * @Route("/proyectos", name="proyectos")
     */
    public function proyectos()
    {
        return $this->render('buscar/proyectos.html.twig', [
            'controller_name' => 'BuscarController',
        ]);
    }
    public function equipo()
    {
        return $this->render('buscar/equipo.html.twig', [
            'controller_name' => 'BuscarController',
        ]);
    }
}
