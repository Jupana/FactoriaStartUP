<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\ProfileUserRepository;
use App\Repository\ProfilRepository;
use App\Repository\SectorRepository;
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

     /**
    * @var sectorRepository
    */
    private $sectorRepository;

    /**
    * @var profilRepository
    */
    private $profilRepository;

    /**
    * @var profilUserRepository
    */
    private $profilUserRepository;


    public function __construct(
        \Twig_Environment $twig, ProjectRepository $projectRepository,ProfileUserRepository $profileUserRepository, ProfilRepository $profilRepository, SectorRepository $sectorRepository
    ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
        $this->profileUserRepository = $profileUserRepository;
        $this->sectorRepository = $sectorRepository;
        $this->profilRepository = $profilRepository;
    }

    public function searchProject()
    {
        $html = $this->twig->render('search/project.html.twig', [
            'projects' => $this->projectRepository->findAll(),
            'opciones_sectores' => $this->sectorRepository->findAll(),
            'opciones_perfil' => $this->profilRepository->findAll() 
        ]);
        return new Response($html);
    }

    public function searchTeam()
    {
        $html = $this->twig->render('search/team.html.twig', [
            'profiles' => $this->profileUserRepository->findAll(),
            'opciones_sectores' => $this->sectorRepository->findAll(),
            'opciones_perfil' => $this->profilRepository->findAll() 
        ]);
        return new Response($html);
    }

}
