<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DetalleProyectoController extends AbstractController
{
    /**
     * @Route("/proyecto", name="proyecto")
     */
    public function index()
    {
        return $this->render('detalle_proyecto/index.html.twig', [
            'controller_name' => 'DetalleProyectoController',
        ]);
    }
}
