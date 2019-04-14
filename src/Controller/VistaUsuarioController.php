<?php
namespace App\Controller;

use App\Entity\ProfileUser;
use App\Entity\User;
use App\Entity\ProfesionalProfile;
use App\Form\ProfileUserType;
use App\Form\UserPersonalInfoType;
use App\Form\ProfesionalProfileType;
use App\Repository\ProfileUserRepository;
use App\Repository\ProfilRepository;
use App\Repository\SectorRepository;
use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class VistaUsuarioController extends AbstractController
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
    private $profileUserRepository;

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
        \Twig_Environment $twig, UserRepository $userRepository,
        ProfileUserRepository $profileUserRepository, ProfilRepository $profilRepository, SectorRepository $sectorRepository,
        FormFactoryInterface $formFactory,EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag
        ) {
        $this->twig = $twig;
        $this->userRepository = $userRepository;
        $this->profileUserRepository = $profileUserRepository;
        $this->sectorRepository = $sectorRepository;
        $this->profilRepository = $profilRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }
   
    public function index_vista()
    {

        return new Response(
            $this->twig->render(
                'vista_usuario/index_vista.html.twig'
            )
        );
    }
     
    public function vista($id)
    {
        $user = $this->userRepository->find($id);
        
        return new Response(
            $this->twig->render(
                'vista_usuario/index_vista.html.twig',
                [
                    'user' => $user
                ]
            )
        );
    }
  
    public function datos_personales(Request $request): Response
    {
        $user = $this->getUser();
        
        $form = $this->createForm(UserPersonalInfoType::class, $user);
        $form->remove('plainPassword');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            $file = $user->getPerfilImg();
            $fileName = $user->getUsername().'-'.$this->generateUniqueFileName().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('imgUsers'),
                    $fileName
                );
            } catch (FileException $e) {
                dump($e);
            }

            $user->setPerfilImg($fileName);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $this->redirectToRoute('datos_personales');

        }
        return $this->render('vista_usuario/datos_Personales-div.html.twig',
            ['user' =>$user,
            'form' =>$form->createView()
            ]);

    }
    
    public function datosProfesionales(Request $request, $id=null): Response
    {       
        $profesionalProfile = $this->getDoctrine()->getRepository(ProfesionalProfile::class);
        $user = $this->getUser();

        $profesionalProfile = $profesionalProfile->findOneBy(['profesionalIdUser' => $user->getId()]);
       
        //Check to see if we have a profesional content and user
        if(!$profesionalProfile){
            $profesionalProfile = new ProfesionalProfile();
            $profesionalProfile->setProfesionalIdUser($user->getId()); 
        }
        $profesionalProfile ->setProfesionalDate((new \DateTime()));
        
        $form = $this->createForm(ProfesionalProfileType::class, $profesionalProfile);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($profesionalProfile);
            $this->entityManager->flush();
            return $this->redirectToRoute('datos_profesionales');
        }
        
        return $this->render('vista_usuario/datos_Profesionales.html.twig',
            ['profesionalProfile' =>$profesionalProfile,
            'form' =>$form->createView(),
            'form_addProfile'=>$this->datosAddProfile($request),
            'profiles' => $this->profileUserRepository->findAll(),
            'formUpdateProfile'=>$this->addProfileUser($request,$id)
            ]);
        
    }

     /**
    * @Route ("/addProfileUser", name="addProfileUser")
    * @param Request $request 
    */
    public function addProfileUser(Request $request , $id=null)
    
    {
        $id=1;
        $profileUser = new ProfileUser();
        $profileUser->setprofileDate(new \DateTime());
        $user=$this->getUser();
        $profileUser->setUser($user);

        dump($profileUser);
       //$profileUser = !$id ? $profileUser : $this->profileUserRepository->find(1);
        
        dump($profileUser);
       
        $profileUserSector = $this->sectorRepository->findOneBy(
            (['name' => $profileUser->getSector()])
        );

        $profileUserProfil = $this->profilRepository->findOneBy(
            (['name'=>$profileUser->getProfil()])
        );
        dump($profileUserSector,$profileUserProfil);
        
        //$profileUser->setSector($profileUserSector);
        //$profileUser->setProfil($profileUserProfil);
        //$profileUser->setProfileDate((new \DateTime()));
        
        //dump($profileUser);die;

        $form = $this->formFactory->create(ProfileUserType::class, $profileUser);
        $form->handleRequest($request);
        return $form->createView();
        
    }


    /**
    * @Route ("/addProfilUserUpdate/{id}", name="addProfilUserUpdate")
    * @param Request $request
    * @param int
    * @return JsonResponse
    */
    public function addProfilUserUpdate(Request $request , int $id)
    
    {
        $ProfileUser = new ProfileUser();

        $ProfileUser->setprofileDate(new \DateTime());
        $user=$this->getUser();
        $ProfileUser->setUser($user);
        
        $profileUser = $this->profileUserRepository->find(3);
        dump($profileUser);
        $form = $this->formFactory->create(ProfileUserType::class, $ProfileUser);
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
                
                $this->entityManager->persist($ProfileUser);
                $this->entityManager->flush();
                $data = $serialzer->serialize($ProfileUser, 'json');
                
                return new JsonResponse($data,200,[], true);

            }
           
        }
        
    }


    public function datosAddProfile(Request $request  )
    {
       
        $profileUser = new ProfileUser();
        $profileUser->setprofileDate(new \DateTime());
        $user=$this->getUser();
        $profileUser->setUser($user);

        $form = $this->formFactory->create(ProfileUserType::class, $profileUser);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($profileUser);
            $this->entityManager->flush(); 
        }
        return $form->createView();
        
    }


    public function datos_proyectos(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/datos_Proyectos.html.twig');
    }
    public function add_proyecto(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/añadir_proyecto.html.twig');
    }
    public function datos_propuestas(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/datos_Propuestas.html.twig');
    }
    public function datos_cuenta(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/datos_Cuenta.html.twig');
    }


    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}