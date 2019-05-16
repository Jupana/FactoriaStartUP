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
                'formProfile' =>$formNewProject->createView()
            ]
        );
    }    

    public function addPerfilToProyect (Request $request, int $id=null){
       
        $newContribute = new Contribute();
                
        $project = $this->projectRepository->find($id);
        $contributeExist   = $this->contributeRepository->findBy(["contribute_project" => $id]);
        
        $newContribute->setContributeIdProject($project);
        $newContribute->setContributeDate(new \DateTime());
        
        if($contributeExist){
            $contributeProject =$contributeExist[0];
            $contributeProject->setContributeProfile( $contributeExist[0]->getContributeProfile());
        }else{
            $contributeProject = $newContribute;
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
                'form_New_Contribute' =>$formNewContribute->createView()
            ]
        );

    }

    public function proyectNeeds(Request $request, int $id=null){

        $newProyectNeeds = new NeedsProject();

        $project = $this->projectRepository->find($id);
        $needsPojectExist   = $this->needsProjectRepository->findBy(["needs_project" => $id]);
        
        //$newProyectNeeds->setNeedsIdProject($project);
        $newProyectNeeds->setNeedsDate(new \DateTime());
        
        if($needsPojectExist){
            var_dump($needsPojectExist);die;
            $newProyectNeeds =$needsPojectExist[0];
           // $newProyectNeeds->setNeedsIdProject( $needsPojectExist[0]->getNeedsIdProject());
        }else{
            $newProyectNeeds = $newProyectNeeds;
        }
        
       /* $formNewProyectNeeds = $this->formFactory->create(NeedsProjectType::class, $newProyectNeeds);
        $formNewProyectNeeds->handleRequest($request);
        
        if($formNewProyectNeeds->isSubmitted() && $formNewProyectNeeds->isValid()){   
            $this->entityManager->persist($newProyectNeeds);
            $this->entityManager->flush();
            return $this->redirectToRoute('datos_proyectos');
        }*/
       
        return $this->render('user_views/addProject_steps/_step4.html.twig',
        [
            //'form_New_Proyect_Needse' =>$formNewProyectNeeds->createView()
        ]
        );
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

    /**
    * @param Request $request 
    */

    public function deleteUserProfile(ProfileUser $ProfileUser, int $id)
    {
        $profileUser = $this->profileUserRepository->find($id);
        $this->entityManager->remove($profileUser);
        $this->entityManager->flush();

        $this->flashBag->add('notice', 'El perfil ha sido eliminado');
        
        return $this->redirectToRoute('datos_profesionales');
    }
}