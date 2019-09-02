<?php
namespace App\Controller;

use App\Entity\ProfileUser;
use App\Entity\Contribute;
use App\Entity\NeedsProject;
use App\Form\ProjectType;
use App\Form\ContributeType;
use App\Form\NeedsProjectType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use App\Repository\ContributeRepository;
use App\Repository\NeedsProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class UserProjectController extends AbstractController
{
        /**
    * @var \Twig_Environment
    */
    private $twig;

    /**
    * @var userRepository
    */
    private $userRepository;
  
      /**
    * @var FormFactoryInterface
    */
    private $formFactory;

    /**
    * @var EntityManagerInterface
    */
    private $entityManager;

    /**
    * @var needsProjectRepository
    */
    private $needsProjectRepository;



    public function __construct(
            \Twig_Environment $twig, 
            UserRepository $userRepository,
            ProjectRepository $projectRepository,
            FormFactoryInterface $formFactory,
            EntityManagerInterface $entityManager,
            ContributeRepository $contributeRepository,
            NeedsProjectRepository $needsProjectRepository
        ) 
        {
            $this->twig = $twig;
            $this->userRepository = $userRepository;
            $this->projectRepository = $projectRepository;
            $this->formFactory = $formFactory;
            $this->entityManager = $entityManager;
            $this->contributeRepository = $contributeRepository;
            $this->needsProjectRepository = $needsProjectRepository;
        }
    
    // Fomr by Steps https://stackoverflow.com/questions/21254733/how-to-split-long-symfony-form-in-multiple-pages
    public function addProject(Request $request, int $id)
    {
        $newProject = $this->projectRepository ->find($id);
        $user=$this->getUser();
        
        $formNewProject = $this->formFactory->create(ProjectType::class, $newProject);
        $formNewProject->handleRequest($request);

        if ($formNewProject->isSubmitted() && $formNewProject->isValid()) {
                
                $file = $formNewProject["project_img"]->getData();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('imgProjects'), $fileName);
              
                $newProject->setProjectImg($fileName);
        
                $this->entityManager->persist($newProject);
                $this->entityManager->flush(); 

                return $this->redirect('/user/add-project/profile/'.$id); 
        }
        return $this->render('user/add-project.html.twig',
            [
                'formProfile' =>$formNewProject->createView(),
                'project'=>$newProject
            ]
        );
    }

    public function addProfileToProject (Request $request, int $id=null){
       
        $newContribute = new Contribute();
        $user = $this->getUser();
                
        $project = $this->projectRepository->find($id);
        $contributeExist   = $this->contributeRepository->findBy(["contribute_project" => $id]);
        
        $newContribute->setContributeIdProject($project);
        $newContribute->setContributeDate(new \DateTime());
        $newContribute->setUser($user);

        $contributeProject = $newContribute;

        $formsProfiles =[];

        foreach($contributeExist  as $profile){
            
            $formsProfiles[$profile->getId()] =$this->formFactory->createNamed('contribute_form_'.$profile->getId(),ContributeType::class,$profile);

            $formsProfiles[$profile->getId()]->handleRequest($request);
            if($formsProfiles[$profile->getId()]->isSubmitted() && $formsProfiles[$profile->getId()]->isValid()){   
                $this->entityManager->persist($profile);
                $this->entityManager->flush();
                return $this->redirectToRoute('add-profile-to-project',['id'=>$id]);
            }

        }
        
        $formNewContribute = $this->formFactory->create(ContributeType::class, $contributeProject);
        $formNewContribute->handleRequest($request);
                
        if($formNewContribute->isSubmitted() && $formNewContribute->isValid()){   
            $this->entityManager->persist($contributeProject);
            $this->entityManager->flush();
            return $this->redirectToRoute('project-needs',['id'=>$id]);
        }
        
        return $this->render('user/add-project-steps/add-profile-to-project.html.twig',
            [
                'form_New_Contribute' =>$formNewContribute->createView(),
                'contributeProject' => $contributeExist,
                'formsProfiles' => array_map ( function ($formsProfiles) {
                    return $formsProfiles->createView();
                }, $formsProfiles),
            ]
        );
    }

    public function deleteProfileProject(int $id)
    {
        $profileProject = $this->contributeRepository->find($id);
        $this->entityManager->remove($profileProject);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('add-profile-to-project',['id'=>$id]);
    }

    public function ProjectNeeds(Request $request, int $id=null){

        $newProjectNeeds = new NeedsProject();
        $user= $this->getUser();

        $project = $this->projectRepository->find($id);
        $needsProjectExist   = $this->needsProjectRepository->findBy(["needs_project" => $id]);
                
        $newProjectNeeds->setNeedsIdProject($project);
        $newProjectNeeds->setNeedsDate(new \DateTime());
        $newProjectNeeds->setUser($user);
               
        if($needsProjectExist){            
          // $newProjectNeeds =$needsProjectExist[0];
          // $newProjectNeeds->setNeedsIdProject($needsProjectExist[0]->getNeedsIdProject());
        }else{
            $newProjectNeeds = $newProjectNeeds;
        }

        $formsProjects =[];
        foreach($needsProjectExist  as $Projects){            
            $formsProjects[$Projects->getId()] =$this->formFactory->createNamed('Projects_form_'.$Projects->getId(),NeedsProjectType::class,$Projects);
            $formsProjects[$Projects->getId()]->handleRequest($request);
            if($formsProjects[$Projects->getId()]->isSubmitted() && $formsProjects[$Projects->getId()]->isValid()){   
                $this->entityManager->persist($Projects);
                $this->entityManager->flush();
                return $this->redirectToRoute('ProjectNeeds',['id'=>$id]);
            }
        }
        
        $formNewProjectNeeds = $this->formFactory->create(NeedsProjectType::class, $newProjectNeeds);
        $formNewProjectNeeds->handleRequest($request);
        
        if($formNewProjectNeeds->isSubmitted() && $formNewProjectNeeds->isValid()){   
            $this->entityManager->persist($newProjectNeeds);
            $this->entityManager->flush();
            return $this->redirectToRoute('projects-info');
        }
       
        dump($formsProjects);
        return $this->render('user/add-project-steps/add-project-needs.html.twig',
        [
            'form_New_Project_Needs' =>$formNewProjectNeeds->createView(),
            'needsProject' =>$needsProjectExist,
            'needsProjectNew' =>$newProjectNeeds,
            'formsProjects' => array_map ( function ($formsProjects) {
                return $formsProjects->createView();
            }, $formsProjects),
        ]
        );
    }


    public function deleteProfileNeeds(int $id)
    {
        $needsProfile = $this->needsProjectRepository->find($id);
        $this->entityManager->remove($needsProfile);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('ProjectNeeds',['id'=>$id]);
    }

    /**
    * @param Request $request 
    */
    public function editProfileUser(Request $request , $id=null)    
    {
        $profileUser = new ProfileUser();
        $profileUser->setprofileDate(new \DateTime());
        $user=$this->getUser();
        $profileUser->setUser($user);
        
        $profileUser = !$id ? $profileUser : $this->profileUserRepository->find($id);
        $formEditProfile = $this->formFactory->create(ProfileUserType::class, $profileUser);
        $formEditProfile->handleRequest($request);

        return $this->render('modals/form-profile.html.twig',
            [
                'formProfile' =>$formEditProfile->createView(),
                'profileUser'=>$profileUser
            ]
        );      
    }
    /**
    * @param Request $request
    * @param int
    * @return JsonResponse
    */
    
    public function editProfilUserUpdate(Request $request , int $id)
    {
        $profileUser = new ProfileUser();

        $profileUser->setprofileDate(new \DateTime());
        $user=$this->getUser();
        $profileUser->setUser($user);
        
        $profileUser = !$id ? $profileUser : $this->profileUserRepository->find($id);

        $profileUser = $this->profileUserRepository->find($id);
        $form = $this->formFactory->create(ProfileUserType::class, $profileUser);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            if($request->isXmlHttpRequest()){
                $encoders = [new JsonEncoder()];

                $normalizers =[
                    (new ObjectNormalizer())->setCircularReferenceHandler(function ($object){
                        return $object->getName();
                    })
                ];

                $serialzer = new Serializer($normalizers, $encoders);
                
                $this->entityManager->persist($profileUser);
                $this->entityManager->flush();
                $data = $serialzer->serialize($profileUser, 'json');
                
                return new JsonResponse($data,200,[], true);
            }  
        }    
    }

    
}