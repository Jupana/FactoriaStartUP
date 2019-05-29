<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
use App\Entity\Sector;
use App\Repository\ProjectRepository;
use App\Repository\ProfileUserRepository;
use App\Repository\ProfilRepository;
use App\Repository\SectorRepository;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query;
use Geocoder\Provider\Provider;
use Geocoder\ProviderAggregator;
use Bazinga\GeocoderBundle\ProviderFactory\GoogleMapsFactory;
use App\Repository\UserRepository;
use App\Services\GetProyects;


class ProjectController extends AbstractController
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

      /**
    * @var FormFactoryInterface
    */
    private $formFactory;

    /**
    * @var EntityManagerInterface
    */
    private $entityManager;

    /**
    * @var FlashBagInterface
    */
    private $flashBag;


    /**
    * @var ProviderAggregator
    */
    private $geoProvider;


    public function __construct(
        \Twig_Environment $twig, ProjectRepository $projectRepository,ProfileUserRepository $profileUserRepository, ProfilRepository $profilRepository, SectorRepository $sectorRepository,
        FormFactoryInterface $formFactory,EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag, ProviderAggregator $geoProvider,UserRepository $userRepository
        ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
        $this->profileUserRepository = $profileUserRepository;
        $this->sectorRepository = $sectorRepository;
        $this->profilRepository = $profilRepository;
        $this->userRepository =$userRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
        $this->geoProvider =$geoProvider;
    }

    public function edit(Project $project, Request $request)
    {
        
        $form = $this->formFactory->create(ProjectType::class,$project);
        $form->handleRequest($request);
        $project->setProjectDate(new \DateTime());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($project);
            $this->entityManager->flush();
            return $this->redirectToRoute('proyectos');
        }
        return new Response(
            $this->twig->render(
                'project/add.html.twig',
                ['form'=>$form->createView()]
            )
        );
    }

    public function add(Request $request)
    {
        $project = new Project();
        $project->setProjectDate(new \DateTime());
        $user=$this->getUser();
        $project->setUser($user);


        $form = $this->formFactory->create(ProjectType::class,$project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($project);
            $this->entityManager->flush();

            return $this->redirectToRoute('proyectos');


        }
        return new Response(
            $this->twig->render(
                'project/add.html.twig',
                ['form'=>$form->createView()]
            )
        );
    }
    public function project($id)
    {
        $project = $this->projectRepository->find($id);
        $profileRepo = $this->profilRepository->findAll();
        $sectorRepo = $this->sectorRepository->findAll();

        return new Response(
            $this->twig->render(
                'project/project.html.twig',
                [
                    'project' => $project,
                    'profileList' => $profileRepo,
                    'sectorList' => $sectorRepo
                ]
            )
        );
    }

    public function indexProject(GetProyects $projects)
    {           
            $projects = $projects->listProyects($this->getUser());
            $html = $this->twig->render('project/index.html.twig', [
                'projects' => $projects,
                'opciones_sectores' => $this->sectorRepository->findAll(),
                'opciones_perfil' => $this->profilRepository->findAll() 
            ]);
            return new Response($html);
    } 
    
    public function indexProjectFilter(GetProyects $projects, $sector, $km,$lat,$long)
    {           
            $projects = $projects->listProyects($this->getUser(),$sector,$km,$lat,$long);
            $html = $this->twig->render('project/index.html.twig', [
                'projects' => $projects,
                'opciones_sectores' => $this->sectorRepository->findAll(),
                'opciones_perfil' => $this->profilRepository->findAll() 
            ]);
            return new Response($html);
    }     
}
