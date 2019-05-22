<?php
namespace App\Controller;

use App\Entity\ProfileUser;
use App\Entity\Contribute;
use App\Entity\NeedsProject;
use App\Entity\Project;
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
    public function add_proyecto(Request $request, int $id)
    {
        $newProject = $this->projectRepository ->find($id);
        $user=$this->getUser();
        
        $formNewProject = $this->formFactory->create(ProjectType::class, $newProject);
        $formNewProject->handleRequest($request);

        if ($formNewProject->isSubmitted() && $formNewProject->isValid()) {
                $this->entityManager->persist($newProject);
                $this->entityManager->flush();          
                return $this->redirect('/vista_usuario/add_proyecto/step_2/'.$id); 
        }
        return $this->render('user_views/AddProject.html.twig',
            [
                'formProfile' =>$formNewProject->createView(),
                'project'=>$newProject
            ]
        );
    }
    
    public function deleteProyect(Project $project)
    {
        $this->entityManager->remove($project);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('datos_proyectos');
    }

    public function addPerfilToProyect (Request $request, int $id=null){
       
        $newContribute = new Contribute();
                
        $project = $this->projectRepository->find($id);
        $contributeExist   = $this->contributeRepository->findBy(["contribute_project" => $id]);
        
        $newContribute->setContributeIdProject($project);
        $newContribute->setContributeDate(new \DateTime());
      
        $contributeProject = $newContribute;

        $formsProfiles =[];

        foreach($contributeExist  as $profile){
            
            $formsProfiles[$profile->getId()] =$this->formFactory->createNamed('contribute_form_'.$profile->getId(),ContributeType::class,$profile);

            $formsProfiles[$profile->getId()]->handleRequest($request);
            if($formsProfiles[$profile->getId()]->isSubmitted() && $formsProfiles[$profile->getId()]->isValid()){   
                $this->entityManager->persist($profile);
                $this->entityManager->flush();
                return $this->redirectToRoute('addPerfilToProyect',['id'=>$id]);
            }

        }
        
        $formNewContribute = $this->formFactory->create(ContributeType::class, $contributeProject);
        $formNewContribute->handleRequest($request);
                
        if($formNewContribute->isSubmitted() && $formNewContribute->isValid()){   
            $this->entityManager->persist($contributeProject);
            $this->entityManager->flush();
            return $this->redirectToRoute('proyectNeeds',['id'=>$id]);
        }
        return $this->render('user_views/addProject_steps/_step3.html.twig',
            [
                'form_New_Contribute' =>$formNewContribute->createView(),
                'contributeProject' => $contributeExist,
                'formsProfiles' => array_map ( function ($formsProfiles) {
                    return $formsProfiles->createView();
                }, $formsProfiles),
            ]
        );

    }


    public function deleteProfileProyect(int $id)
    {
        $profileProyect = $this->contributeRepository->find($id);
        $this->entityManager->remove($profileProyect);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('addPerfilToProyect',['id'=>$id]);
    }

    public function proyectNeeds(Request $request, int $id=null){

        $newProyectNeeds = new NeedsProject();

        $project = $this->projectRepository->find($id);
        $needsProyectExist   = $this->needsProjectRepository->findBy(["needs_project" => $id]);
                
        $newProyectNeeds->setNeedsIdProject($project);
        $newProyectNeeds->setNeedsDate(new \DateTime());
               
        if($needsProyectExist){            
          // $newProyectNeeds =$needsProyectExist[0];
          // $newProyectNeeds->setNeedsIdProject($needsProyectExist[0]->getNeedsIdProject());
        }else{
            $newProyectNeeds = $newProyectNeeds;
        }

        $formsProyects =[];
        foreach($needsProyectExist  as $proyects){            
            $formsProyects[$proyects->getId()] =$this->formFactory->createNamed('proyects_form_'.$proyects->getId(),NeedsProjectType::class,$proyects);
            $formsProyects[$proyects->getId()]->handleRequest($request);
            if($formsProyects[$proyects->getId()]->isSubmitted() && $formsProyects[$proyects->getId()]->isValid()){   
                $this->entityManager->persist($proyects);
                $this->entityManager->flush();
                return $this->redirectToRoute('proyectNeeds',['id'=>$id]);
            }
        }
        
        $formNewProyectNeeds = $this->formFactory->create(NeedsProjectType::class, $newProyectNeeds);
        $formNewProyectNeeds->handleRequest($request);
        
        if($formNewProyectNeeds->isSubmitted() && $formNewProyectNeeds->isValid()){   
            $this->entityManager->persist($newProyectNeeds);
            $this->entityManager->flush();
            return $this->redirectToRoute('datos_proyectos');
        }
       
        return $this->render('user_views/addProject_steps/_step4.html.twig',
        [
            'form_New_Proyect_Needs' =>$formNewProyectNeeds->createView(),
            'needsProyect' =>$needsProyectExist,
            'needsProyectNew' =>$newProyectNeeds,
            'formsProyects' => array_map ( function ($formsProyects) {
                return $formsProyects->createView();
            }, $formsProyects),
        ]
        );
    }


    public function deleteProfileNeeds(int $id)
    {
        $needsProfile = $this->needsProjectRepository->find($id);
        $this->entityManager->remove($needsProfile);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('proyectNeeds',['id'=>$id]);
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

        return $this->render('modals/FormPerfil.html.twig',
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