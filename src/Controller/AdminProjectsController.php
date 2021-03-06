<?php

namespace App\Controller;

use App\Entity\Coworking;
use App\Form\CoworkingType;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use App\Repository\CoworkingRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NeedsProjectRepository;
use App\Repository\ContributeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;




class AdminProjectsController extends AbstractController
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
    * @var FormFactoryInterface
    */
    private $formFactory;

    /**
    * @var EntityManagerInterface
    */
    private $entityManager;

    /**
    * @var NeedRepository
    */
    private $needsRepository;

    /**
    * @var ContributeRepository
    */
    private $contributeRepository;

    /**
    * @var CoworkingRepository
    */
    private $coworkingRepository;

    /**
    * @var FlashBagInterface
    */
    private $flashBag;

    public function __construct(
        \Twig_Environment $twig, 
        ProjectRepository $projectRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,        
        UserRepository $userRepository,
        NeedsProjectRepository $needsRepository,
        ContributeRepository $contributeRepository,
        CoworkingRepository $coworkingRepository,
        FlashBagInterface $flashBag
        ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
        $this->userRepository =$userRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;  
        $this->needsRepository = $needsRepository;  
        $this->contributeRepository = $contributeRepository; 
        $this->coworkingRepository = $coworkingRepository;  
        $this->flashBag = $flashBag;  
    }
  
    public function index()
    {
        $projects = $this->projectRepository->findAll();
      
        return new Response(
            $this->twig->render(
                'admin/index.html.twig',
                [
                    'projects' => $projects                        
                ]
            )
        );       
    }

    public function project($id)
    { 
        
        $project = $this->projectRepository ->find($id);
        $needsProject = $this->needsRepository->findBy(['needs_project'=>$id]);
        $contributeProjects = $this->contributeRepository->findBy(['contribute_project'=>$id]);
        return new Response(
            $this->twig->render(
                'admin/project.html.twig',
                [
                    'project' => $project ,
                    'needsProject'  =>$needsProject ,
                    'contributeProjects' =>$contributeProjects                
                ]
            )
        ); 
    }

}
