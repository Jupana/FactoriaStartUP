<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SearchController extends AbstractController
{   
    /**
    * @var \Twig_Environment
    */
    private $twig;

    /**
    * @var projectRepository
    */
    private $projectRepository;

    public function __construct(
        \Twig_Environment $twig, ProjectRepository $projectRepository
    ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
    }

    public function searchProject()
    {
        $html = $this->twig->render('search/project.html.twig', [
            'projects' => $this->projectRepository->findAll()
        ]);
        return new Response($html);
    }

    public function searchTeam()
    {
        return $this->render('search/team.html.twig', array(
            'controller_name' => 'SearchController',
        ));
    }
}
