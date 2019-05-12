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
use Bazinga\GeocoderBundle\ProviderFactory\GoogleMapsFactory;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;
use Geocoder\Provider\Provider;



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


    public function __construct(
        \Twig_Environment $twig, ProjectRepository $projectRepository,ProfileUserRepository $profileUserRepository, ProfilRepository $profilRepository, SectorRepository $sectorRepository,
        FormFactoryInterface $formFactory,EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag
        ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
        $this->profileUserRepository = $profileUserRepository;
        $this->sectorRepository = $sectorRepository;
        $this->profilRepository = $profilRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
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

    public function delete(Project $project)
    {
        $this->entityManager->remove($project);
        $this->entityManager->flush();

        $this->flashBag->add('notice', 'Proyecto ha sido eliminado');
        
        return $this->redirectToRoute('proyectos');
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

        return new Response(
            $this->twig->render(
                'project/project.html.twig',
                [
                    'project' => $project
                ]
            )
        );
    }

    public function indexProject(GoogleMapsFactory $geoCodingProvider )
    {
        $config = []; 
        $config['api_key'] = 'AIzaSyDmQm7vyUCKhZ_rxCyM8kTtxSN4YfDNc3M'; 
        $config['region'] ='es_ES';

        $provider = $geoCodingProvider->createProvider($config); 
        $result = $provider->geocodeQuery(GeocodeQuery::create('Calle Vila de Donas 13'));
       
        var_dump($result);die;
        
    $html = $this->twig->render('project/index.html.twig', [
            'projects' => $this->projectRepository->findBy([],['project_date'=>'DESC']),
            'opciones_sectores' => $this->sectorRepository->findAll(),
            'opciones_perfil' => $this->profilRepository->findAll() 
        ]);
        return new Response($html);
    }
}
