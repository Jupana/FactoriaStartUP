<?php
namespace App\Controller;

use App\Entity\ProfileUser;
use App\Entity\User;
use App\Form\ProfileUserType;
use App\Form\UserPersonalInfoType;
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
        $form->handleRequest($request);

        return $this->render('vista_usuario/datos_Personales.html.twig',
            ['user' =>$user,
            'form' =>$form->createView()
            ]);
    }
    public function datos_profesionales(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/datos_Profesionales.html.twig');
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
}