<?php
namespace App\Controller;

use App\Entity\ProfileUser;
use App\Entity\Contribute;
use App\Form\ProjectType;
use App\Form\ContributeType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use App\Repository\ContributeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
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
    * @var FlashBagInterface
    */
    private $flashBag;


    public function __construct(
            \Twig_Environment $twig, 
            UserRepository $userRepository,
            ProjectRepository $projectRepository,
            FormFactoryInterface $formFactory,
            EntityManagerInterface $entityManager,
            FlashBagInterface $flashBag,
            ContributeRepository $contributeRepository
        ) 
        {
            $this->twig = $twig;
            $this->userRepository = $userRepository;
            $this->projectRepository = $projectRepository;
            $this->formFactory = $formFactory;
            $this->entityManager = $entityManager;
            $this->flashBag = $flashBag;
            $this->contributeRepository = $contributeRepository;
        }
  
    /**
    *
    *@param Request $request 
    */
    public function addProject(Request $request, int $id=null)
    {
        $newProject = $this->projectRepository ->find($id);
        $user=$this->getUser();
        
        $formNewProject = $this->formFactory->create(ProjectType::class, $newProject);
        $formNewProject->handleRequest($request);

        if ($formNewProject->isSubmitted() && $formNewProject->isValid()) {
                $this->entityManager->persist($newProject);
                $this->entityManager->flush();
                      
            //return $this->redirect('/vista_usuario/add_proyecto/step_2/'.$id);

            
        }
        return $this->render('user_views/addProject_steps/_step1.html.twig',
            [
                'formProfile' =>$formNewProject->createView()
            ]
        );      
    }


    public function addPerfilToProyect (Request $request, int $id=null){
       
        $newContribute = new Contribute();
        $request = $this->get('request_stack')->getMasterRequest();
       
                
        $project = $this->projectRepository->find($id);
        $contributeExist   = $this->contributeRepository->findBy(["contribute_project" => $id]);
        
        $newContribute->setContributeIdProject($project);
        $newContribute->setContributeDate(new \DateTime());
       
        //$contributeProject = $contributeExist ? $contributeExist[0] : $newContribute;
        //$contributeProject->setContributeProfile( $contributeExist[0]->getContributeProfile());
        
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
            return $this->redirectToRoute('addPerfilToProyect');
        }
        return $this->render('user_views/addProject_steps/_step3.html.twig',
            [
                'form_New_Contribute' =>$formNewContribute->createView()
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