<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DetalleController extends AbstractController
{
    /**
     * @Route("/proyecto", name="proyecto")
     */
    public function proyecto()
    {
        return $this->render('detalle/proyecto.html.twig', [
            'controller_name' => 'DetalleController',
        ]);
    }
    public function usuario()
    {
        return $this->render('detalle/usuario.html.twig', [
            'controller_name' => 'DetalleController',
        ]);
    }
}
