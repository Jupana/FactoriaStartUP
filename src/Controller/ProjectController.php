<?php

namespace App\Controller;

use App\Entity\InterestProject;
use App\Entity\Notification;
use App\Entity\ProfileUser;
use App\Entity\Message;
use App\Form\InterestProjectType;
use App\Repository\ProjectRepository;
use App\Repository\ProfileUserRepository;
use App\Repository\ProfilRepository;
use App\Repository\SectorRepository;
use App\Repository\ContributeRepository;
use App\Repository\NeedsProjectRepository;
use App\Repository\InterestProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use App\Services\GetProjects;
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
    * @var InterestProjectRepository
    */
    private $interestProject;

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
        NeedsProjectRepository $needsProjectRepository,
        InterestProjectRepository $interestProject
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
        $this->interestProject = $interestProject;
    }

    public function project( Request $request, $id, SendMailInterest $sendMailProjectInterest)
    {
        $project = $this->projectRepository->find($id);
        $contributeProject = $this->contributeRepository->findBy(['contribute_project'=>$id]);
        $needProject = $this->needsProjectRepository->findBy(['needs_project'=>$id]);
       

        if($this->getuser()){
            $interestProject = new InterestProject;
            $interestProject->setInterestDate(new \DateTime());
            $interestProject->setInterestIdUser($this->getUser());
            $interestProject->setInterestProjectOwnerID($project->getUser());
            $interestProject->setInterestIdProject($project);            
            $interestProject->setInterestStatusContribute(true);
            $interestProject->setInterestStatusOwner(false);
            
            $formAddInterestProject = $this->formFactory->create(InterestProjectType::class, $interestProject);
            $formAddInterestProject->handleRequest($request);
    
            if ($formAddInterestProject->isSubmitted() && $formAddInterestProject->isValid()) {
                $interestDeal = $formAddInterestProject->get('interest_deal')->getData();
                $interestPercent = $formAddInterestProject->get('interest_percent')->getData();
                $interestDes = $formAddInterestProject->get('extra_profile_des')->getData();

                $interestProject->setInterestDeal($interestDeal);
                $interestProject->setInterestPercent($interestPercent);
                $interestProject->setInterestDescription($interestDes);
                /*We create here also a new profile if the user want to add it from MeInteresa you have to REFACTOR this this*/
                                
                if ($interestProject->getInterestSector()){
                    $sectorId = $this->sectorRepository ->findBy(['name'=>$interestProject->getInterestSector()]);
                    $profileId = $this->profilRepository ->findBy(['name'=>$interestProject->getInterestProfil()->getName()]);
                    
                    //Here we add new Profile for User if he don't has it
                    $profileUser = new ProfileUser();
                    $profileUser->setUser($this->getuser());
                    $profileUser->setSector($sectorId[0]);
                    $profileUser->setProfil($profileId[0]);
                    $profileUser->setDescription($interestDes);
                    $profileUser->setprofileDate(new \DateTime());
                    $this->entityManager->persist($profileUser);
                }

                 $mailInterestProject =[
                     'userName'=>$this->getUser()->getUsername(),
                     'userMail' =>$this->getUser()->getEmail(),
                     'ownerName'=>$project->getUser()->getUsername(),
                     'ownerMail' =>$project->getUser()->getEmail(),
                     'projectName' =>$project->getProjectName(),
                     'sectorInterest'=>$interestProject->getInterestSector(),
                     'ProfileInterest'=>$interestProject->getInterestProfil(),
                     'dealInterest'=>$interestDeal,
                     'percentInterest'=>$interestPercent,
                     'descriptionInterest'=>$interestDes,

                 ];
                 
                 $createNotification =  new Notification();
                 $createNotification->setUser($project->getUser());
                 $createNotification->setType('project_interest');
                 $createNotification->setInterestProject($interestProject);
                 $createNotification->setSeen(false);
                 $createNotification->setTime(new \DateTime()); 

                 $userSenderId =$this->getUser()->getId();
                 $userRecipientId=$project->getUser()->getId();
                 $idConv = $userSenderId.'-'.$userRecipientId.'-'.rand(1000,10000000);
               
                 
                 $message = new Message();
                 $message->setUserSender($this->getUser());
                 $message->setUserRecipient($project->getUser());
                 $message->setInterestProject($interestProject);
                 $message->setType('project_interest');
                 $message->setTime(new \DateTime());
                 $message->setText('Tienes que ver por que no te salen la descripcion interestDes');
                 $message->setConversationId($idConv);
                
                $sendMailProjectInterest->sendMailProject($mailInterestProject);                

                $this->entityManager->persist($interestProject);
                $this->entityManager->persist($createNotification);
                $this->entityManager->persist($message);
                $this->entityManager->flush();   
                
                $this->flashBag->add('notice', 'Mensaje Enviado');
            }

            dump($this->getUser());
            dump('Contribute',$this->getUser()->getContribute()->getValues());
            dump('Notifications',$this->getUser()->getNotifications()->getValues());
            dump('InteresProfileID',$this->getUser()->getInterestProfileId()->getValues());
            dump('InterestProject',$this->getUser()->getInterestProjectId()->getValues());
            
            
            $matchInterestProject = $this->getInterestProjectBefore($this->getUser()->getInterestProjectId()->getValues(),$id);            
            
            return new Response(
                $this->twig->render(
                    'project/project.html.twig',
                    [
                        'project' => $project,
                        'contributeProject' => $contributeProject,
                        'needsProject' =>$needProject,
                        'formInterstProject' =>$formAddInterestProject->createView(),
                        'matchInterestProject'=>$matchInterestProject
                        
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

    public function indexProject(GetProjects $projects)
    {           
            $projects = $projects->listProjects($this->getUser());
            $html = $this->twig->render('project/index.html.twig', [
                'projects' => $projects,
                'opciones_sectores' => $this->sectorRepository->findAll(),
                'opciones_Profile' => $this->profilRepository->findAll() 
            ]);
            return new Response($html);
    } 
    
    public function indexProjectFilter(GetProjects $projects, $sector, $km,$lat,$long)
    {           
            $projects = $projects->listProjects($this->getUser(),$sector,$km,$lat,$long);
            $html = $this->twig->render('project/index.html.twig', [
                'projects' => $projects,
                'opciones_sectores' => $this->sectorRepository->findAll(),
                'opciones_Profile' => $this->profilRepository->findAll() 
            ]);
            return new Response($html);
    }
    
    public function getInterestProjectBefore($interestProjects, $projectid){
        $match = false;
        if(!empty($interestProjects)){
            foreach($interestProjects as $project){
                if($project->getInterestIdProject()->getId()== $projectid)
                $match= true;
            }
        }
            
         
        
        return $match;


    }
}
