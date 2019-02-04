<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NoticiasController extends AbstractController
{
    /**
     * @Route("/noticias", name="noticias")
     */
    public function index()
    {
        return $this->render('noticias/index.html.twig', [
            'controller_name' => 'NoticiasController',
        ]);
    }
    public function noticias()
    {
        return $this->render('noticias/noticia.html.twig', [
            'controller_name' => 'NoticiasController',
        ]);
    }
}
