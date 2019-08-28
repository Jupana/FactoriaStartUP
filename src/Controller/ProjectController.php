<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\InterestProject;
use App\Entity\Notification;
use App\Entity\ProfileUser;
use App\Form\InterestProjectType;
use App\Repository\ProjectRepository;
use App\Repository\ProfileUserRepository;
use App\Repository\ProfilRepository;
use App\Repository\SectorRepository;
use App\Repository\ContributeRepository;
use App\Repository\NeedsProjectRepository;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use App\Services\GetProyects;
use App\Services\SendMailInterest;




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
        \Twig_Environment $twig, 
        ProjectRepository $projectRepository,
        ProfileUserRepository $profileUserRepository, 
        ProfilRepository $profilRepository, 
        SectorRepository $sectorRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag,
        UserRepository $userRepository,
        ContributeRepository $contributeRepository,
        NeedsProjectRepository $needsProjectRepository
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
        $this->contributeRepository=$contributeRepository;
        $this->needsProjectRepository=$needsProjectRepository;
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
    public function project( Request $request, $id, SendMailInterest $sendMailProjectInterest)
    {
        $project = $this->projectRepository->find($id);
        $contributeProject = $this->contributeRepository->findBy(['contribute_project'=>$id]);
        $needProject = $this->needsProjectRepository->findBy(['needs_project'=>$id]);       

        if($this->getuser()){
            $interestProyect = new InterestProject;
            $interestProyect->setInterestDate(new \DateTime());
            $interestProyect->setInterestIdUser($this->getUser()->getID());
            $interestProyect->setInterestProjectOwnerID($project->getUser()->getId());
            $interestProyect->setInterestIdProject($id);            
            $interestProyect->setInterestStatusContribute(true);
            $interestProyect->setInterestStatusOwner(false);
            
            $formAddInterestProyect = $this->formFactory->create(InterestProjectType::class, $interestProyect);
            $formAddInterestProyect->handleRequest($request);
    
            if ($formAddInterestProyect->isSubmitted() && $formAddInterestProyect->isValid()) {
                
                /*We create here also a new profile if the user want to add it from MeInteresa you have to REFACTOR this this*/
                
                if ($interestProyect->getInterestSector()){
                    $sectorId = $this->sectorRepository ->findBy(['name'=>$interestProyect->getInterestSector()]);
                    $profileId = $this->profilRepository ->findBy(['name'=>$interestProyect->getInterestProfil()->getName()]);
                    dump($sectorId,$interestProyect->getInterestProfil(),$profileId);
                    //Here we add new Profile for User if he don't has it
                    $profileUser = new ProfileUser();
                    $profileUser->setUser($this->getuser());
                    $profileUser->setSector($sectorId[0]);
                    $profileUser->setProfil($profileId[0]);
                    $profileUser->setDescription($formAddInterestProyect->get('extra_profile_des')->getData());
                    $profileUser->setprofileDate(new \DateTime());
                    $this->entityManager->persist($profileUser);
                }

                 $mailInterestProject =[
                     'userName'=>$this->getUser()->getUsername(),
                     'userMail' =>$this->getUser()->getEmail(),
                     'ownerName'=>$project->getUser()->getUsername(),
                     'ownerMail' =>$project->getUser()->getEmail(),
                     'projectName' =>$project->getProjectName(),
                     'sectorInterest'=>$interestProyect->getInterestSector(),
                     'perfilInterest'=>$interestProyect->getInterestProfil(),
                     'dealInterest'=>$interestProyect->getInterestDeal(),
                     'percentInterest'=>$interestProyect->getInterestPercent(),
                     'descriptionInterest'=>$interestProyect->getInterestDescription(),

                 ];                         
                
                $sendMailProjectInterest->sendMailProject($mailInterestProject);                

                $this->entityManager->persist($interestProyect);
                $this->entityManager->flush();   
                
                $this->flashBag->add('notice', 'Mensaje Enviado');
            }


            dump($this->getUser());
            dump('Contribute',$this->getUser()->getContribute()->getValues());
            dump('Notifications',$this->getUser()->getNotifications()->getValues());
            dump('InteresProfileID',$this->getUser()->getInterestProfileId()->getValues());
            //dump('Contribute',$this->getUser()->getContribute()->getValues()[0]->getContributeIdProject()->getId());
            //dump('InteresProfileID',$this->getUser()->getInterestProfileId()->getValues());
            //dump('Projects',$this->getUser()->getProjects()->getValues());
            //dump($this->getUser()->getNotifications()->getIterator());            
    
            return new Response(
                $this->twig->render(
                    'project/project.html.twig',
                    [
                        'project' => $project,
                        'contributeProject' => $contributeProject,
                        'needsProject' =>$needProject,
                        'formInterstProject' =>$formAddInterestProyect->createView(),
                        
                    ]
                )
            );
        }else{
            return new Response(
                $this->twig->render(
                    'project/project.html.twig',
                    [
                        'project' => $project,
                        'contributeProject' => $contributeProject,
                        'needsProject' =>$needProject,
                        
                    ]
                )
            );
        }
       
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
    
    public function getInterestProyectBefore(){


    }
}
