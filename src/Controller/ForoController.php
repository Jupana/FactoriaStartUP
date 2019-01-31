<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ForoController extends AbstractController
{
    /**
     * @Route("/foro", name="foro")
     */
    public function index()
    {
        return $this->render('foro/index.html.twig', [
            'controller_name' => 'ForoController',
        ]);
    }
}
