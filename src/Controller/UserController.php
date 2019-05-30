<?php
namespace App\Controller;

use App\Entity\ProfesionalProfile;
use App\Entity\Project;
use App\Form\UserPersonalInfoType;
use App\Form\ProfesionalProfileType;
use App\Form\ProjectNameType;
use App\Repository\ProfileUserRepository;
use App\Repository\ProfilRepository;
use App\Repository\SectorRepository;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use App\Repository\NeedsProjectRepository;
use App\Repository\ContributeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Repository\ProfesionalProfileRepository;
use Geocoder\Query\GeocodeQuery;
use Bazinga\GeocoderBundle\ProviderFactory\GoogleMapsFactory;

class UserController extends AbstractController
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
    * @var ProjectRepository
    */
    private $projectsUserRepository;

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
        ProfileUserRepository $profileUserRepository, 
        ProfilRepository $profilRepository,
        SectorRepository $sectorRepository, 
        ProfesionalProfileRepository $profesionalProfilRespository,
        ProjectRepository $projectsUserRepository,
        NeedsProjectRepository $needsProjectRepository,
        ContributeRepository $contributeRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag
        ) {
        $this->twig = $twig;
        $this->userRepository = $userRepository;
        $this->profileUserRepository = $profileUserRepository;
        $this->sectorRepository = $sectorRepository;
        $this->profilRepository = $profilRepository;
        $this->profesionalProfilRespository = $profesionalProfilRespository;
        $this->projectsUserRepository = $projectsUserRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
        $this->needsProjectRepository = $needsProjectRepository;
        $this->contributeRepository = $contributeRepository;
    }
   
    public function index_vista()
    {
        $user = $this->getUser();
        $userProfesionalProfile = $this->profesionalProfilRespository->findOneBy(['profesionalIdUser' => $user->getId()]);        
        $userProjects = $this->projectsUserRepository->findBy(['user' => $user->getId()]);
        return new Response(
            $this->twig->render(
                'user_views/index_vista.html.twig',
                [
                    'user' => $user,
                    'profesionalProfile' =>$userProfesionalProfile,
                    'userProjects' =>$userProjects
                ]
            )
        );
    }
  
    public function datos_personales(Request $request, GoogleMapsFactory $geoCodingProvider): Response
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

            $config = []; 
            $config['api_key'] = 'xxx'; 
               
            $provider = $geoCodingProvider->createProvider($config); 
            $result =  $provider->geocodeQuery(GeocodeQuery::create(
                $user->getStreetName().' '.
                $user->getStreetName().' '.
                $user->getStreetNumber().' '.
                $user->getCity().' '.
                $user->getPostalCode().' '.
                $user->getProvince().' '. 
                $user->getCountry().' '
            ));
            $coords = $result->first()->getCoordinates();

            $lat =$coords->getLatitude();
            $long = $coords->getLongitude();

            $user->setLatitud($lat);
            $user->setLongitud($long);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $this->redirectToRoute('datos_personales');

        }
        return $this->render('user_views/PersonalData.html.twig',
            ['user' =>$user,
            'form' =>$form->createView()
            ]);

    }
    
    public function datosProfesionales(Request $request): Response
    {       
        $profesionalProfile = $this->profesionalProfilRespository;
        $user = $this->getUser();

        $profesionalProfile = $profesionalProfile->findOneBy(['profesionalIdUser' => $user->getId()]);
        
        $userProfiles = $this->profileUserRepository->findBy(['user'=> $user->getId()]);
        
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
        
        return $this->render('user_views/ProfessionalData.html.twig',
            [
                'profesionalProfile' =>$profesionalProfile,
                'form' =>$form->createView(),
                'profiles' => $userProfiles,
                
            ]);
        
    }
    
    public function datosProyectos(Request $request): Response
    {
        $newProject = new Project();
        $user = $this->getUser();
        $newProject->setUser($user);

        //Check User Projects
        
        $userProjects = $this->projectsUserRepository->findBy(['user' => $user->getId()]);
        $userNeedsProjects =   $this->needsProjectRepository->findBy(['user'=> $user->getId()]);
        $userContributeProjects = $this->contributeRepository->findBy(['user'=> $user->getId()]);
        
        $formNewProject = $this->createForm(ProjectNameType::class,$newProject);
        $formNewProject->handleRequest($request);

        if($formNewProject->isSubmitted() && $formNewProject->isValid()){
            $this->entityManager->persist($newProject);
            $this->entityManager->flush();

            return $this->redirectToRoute('add_proyecto',['id'=>$newProject->getid()]);
        }
        return $this->render('user_views/datos_Proyectos.html.twig',
                    [
                        'formAddProject' =>$formNewProject->createView(),
                        'userProjects' =>$userProjects,
                        'userNeedsProjects'=>$userNeedsProjects,
                        'userContributeProjects'=>$userContributeProjects
                        
                    ]
            );
    }
    
    public function datos_propuestas(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('user_views/datos_Propuestas.html.twig');
    }
    public function datos_cuenta(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('user_views/datos_Cuenta.html.twig');
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
