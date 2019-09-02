<?php

namespace App\Controller;


use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


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

    public function __construct(
        \Twig_Environment $twig, 
        ProjectRepository $projectRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,        
        UserRepository $userRepository
        ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
        $this->userRepository =$userRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;        
    }
  
    public function index()
    {
        $projects = $this->projectRepository->findAll();
        dump($this->getUser()->getRoles());
    
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
        return new Response(
            $this->twig->render(
                'admin/project.html.twig',
                [
                    'project' => $project                        
                ]
            )
        ); 
    }

    public function index_coworker()
    {
            return $this->render('admin/coworker.html.twig');

    }
}
