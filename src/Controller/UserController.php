<?php
namespace App\Controller;

use App\Entity\InterestProfile;
use App\Entity\InterestProject;
use App\Entity\ProfesionalProfile;
use App\Entity\Project;
use App\Form\UserPersonalInfoType;
use App\Form\ProfesionalProfileType;
use App\Form\ProjectNameType;
use App\Repository\InterestProfileRepository;
use App\Repository\InterestProjectRepository;
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

    /**
    * @var InterestProfileRepository
    */
    private $interestProfileRepository;

    /**
    * @var InterestProjectRepository
    */
    private $interestProjectRepository;




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
        FlashBagInterface $flashBag,
        InterestProfileRepository $interestProfileRepository,
        InterestProjectRepository $interestProjectRepository

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
        $this->interestProfileRepository = $interestProfileRepository;
        $this->interestProjectRepository = $interestProjectRepository;
    }
   
    public function index_vista()
    {
        $user = $this->getUser();
        $userProfesionalProfile = $this->profesionalProfilRespository->findOneBy(['profesionalIdUser' => $user->getId()]);        
        $userProjects = $this->projectsUserRepository->findBy(['user' => $user->getId()]);
        return new Response(
            $this->twig->render(
                'user/index.html.twig',
                [
                    'user' => $user,
                    'profesionalProfile' =>$userProfesionalProfile,
                    'userProjects' =>$userProjects
                ]
            )
        );
    }
  
    public function personalInfo(Request $request, GoogleMapsFactory $geoCodingProvider): Response
    {
        $user = $this->getUser();
        
        $form = $this->createForm(UserPersonalInfoType::class, $user);
        $form->remove('plainPassword');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            $file = $user->getProfileImg();
            $fileName = $user->getUsername().'-'.$this->generateUniqueFileName().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('imgUsers'),
                    $fileName
                );
            } catch (FileException $e) {
                dump($e);
            }

            $user->setProfileImg($fileName);

            $config = []; 
            $config['api_key'] = 'AIzaSyDmQm7vyUCKhZ_rxCyM8kTtxSN4YfDNc3M'; 
               
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
            return $this->redirectToRoute('personal-info');

        }
        return $this->render('user/personal-info.html.twig',
            ['user' =>$user,
            'form' =>$form->createView()
            ]);

    }
    
    public function professionalInfo(Request $request): Response
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
            return $this->redirectToRoute('user/professional-info');
        }
        
        return $this->render('user/professional-info.html.twig',
            [
                'profesionalProfile' =>$profesionalProfile,
                'form' =>$form->createView(),
                'profiles' => $userProfiles,
                
            ]);
        
    }
    
    public function projectsInfo(Request $request): Response
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

            return $this->redirectToRoute('add-project',['id'=>$newProject->getid()]);
        }        
        
        return $this->render('user/projects-info.html.twig',
                    [
                        'formAddProject' =>$formNewProject->createView(),
                        'userProjects' =>$userProjects,
                        'userNeedsProjects'=>$userNeedsProjects,
                        'userContributeProjects'=>$userContributeProjects
                        
                    ]
            );
    }
    
    
    public function proposalsInfo(): Response
    {
        
        $searchprofiles = $this->interestProfileRepository->findBy(['user'=>$this->getUser()->getId()]);
        $searchProfilesPartner = $this->interestProfileRepository->findBy(['user_profile_owner'=>$this->getUser()->getId()]);
        
        $searchProjects = $this->interestProjectRepository->findBy(['interest_user'=>$this->getUser()]);
        $searchProjectsToColaborate = $this->interestProjectRepository->findBy(['interest_project_owner'=>$this->getUser()->getId()]);
              
        $usersSearchData=[];
        $i=0;

        foreach($searchprofiles as $searchprofile){
            $userSearch =  $this->userRepository->findBy(['id'=>$searchprofile->getUserProfileOwner()]);
          
           if($userSearch){
            $usersSearchData[$i]['user']['id'] =$userSearch[0]->getId();
            $usersSearchData[$i]['user']['userName']=$userSearch[0]->getUsername();

            $userSearchProfil =$this->profilRepository->find($searchprofile->getInterestProfile());

            $usersSearchData[$i]['userProfile']['id'] =$userSearchProfil->getId();
            $usersSearchData[$i]['userProfile']['profileName']=$userSearchProfil->getName();
           } 

            if($searchprofile->getInterestProject()){
                $userSearchProject =$this->projectsUserRepository->find($searchprofile->getInterestProject()->getId());
                $usersSearchData[$i]['Project']['id'] =$userSearchProject->getId();
                $usersSearchData[$i]['Project']['ProjectName']=$userSearchProject->getProjectName();
            }
            
            $i++;       
        }

        $usersSearchProjectData=[];
        $n=0;
        foreach($searchProjects as $serachProject){
            $wantSearchProject =  $this->projectsUserRepository->find($serachProject->getInterestIdProject());
            
            $usersSearchProjectData[$n]['Project']['id'] =$wantSearchProject->getId();
            $usersSearchProjectData[$n]['Project']['ProjectName']=$wantSearchProject->getProjectName();
            
            $n++;       
        }


        $userProjectsToColaborate =[];
        $k=0;
        foreach($searchProjectsToColaborate as $searchProjectToColaborate){
            $userSearch = $this->userRepository->find($searchProjectToColaborate->getInterestIdUser());
            $userProjectsToColaborate[$k]['userData']['id'] = $userSearch->getId();
            $userProjectsToColaborate[$k]['userData']['userName'] = $userSearch->getUsername();
            
            $userSearchProjectToColaborate =$this->projectsUserRepository->find($searchProjectToColaborate->getInterestIdProject());
            $userProjectsToColaborate[$k]['Project']['id'] =$userSearchProjectToColaborate->getId();
            $userProjectsToColaborate[$k]['Project']['ProjectName']=$userSearchProjectToColaborate->getProjectName();
            
            $k++;
        }


        $usersProfileForPartner=[];
        $x=0;
        foreach($searchProfilesPartner as $searchprofile){
            $userSearch =  $this->userRepository->findBy(['id'=>$searchprofile->getUserProfileOwner()]);
            $usersProfileForPartner[$x]['user']['id'] =$userSearch[0]->getId();
            $usersProfileForPartner[$x]['user']['userName']=$userSearch[0]->getUsername();

            $userSearchProfil =$this->profilRepository->find($searchprofile->getInterestProfile());

            $usersProfileForPartner[$x]['userProfile']['id'] =$userSearchProfil->getId();
            $usersProfileForPartner[$x]['userProfile']['profileName']=$userSearchProfil->getName();
        
            $userSearchProject =$this->projectsUserRepository->find($searchprofile->getInterestProject());

            $usersProfileForPartner[$x]['Project']['id'] =$userSearchProject->getId();
            $usersProfileForPartner[$x]['Project']['ProjectName']=$userSearchProject->getProjectName();
            
            $x++;       
        }        
        return $this->render('user/proposals-info.html.twig',
            [
                'searchprofiles'=>$searchprofiles,
                'usersSearchData' =>$usersSearchData,                
                'searchProjects'=>$searchProjects,
                'usersSearchProjectData'=>$usersSearchProjectData,
                'searchProjectsToColaborate'=>$searchProjectsToColaborate,
                'userProjectsToColaborate'=>$userProjectsToColaborate,
                'searchProfilesPartner'=>$searchProfilesPartner,
                'usersProfileForPartner'=>$usersProfileForPartner

            ]
        );
    }

    public function deleteProject(Project $project)    
    {
        
        $needProjects = $this->needsProjectRepository->findBy(['needs_project'=>$project->getId()]);
        $contributes  = $this->contributeRepository->findBy(['contribute_project'=>$project->getId()]);
        
        foreach($needProjects as $needProject){
            $this->entityManager->remove($needProject);    
        }
        
        foreach($contributes as $contribute){
            $this->entityManager->remove($contribute);    
        }
        $this->entityManager->remove($project);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('projects-info');
    }

    public function deleteProjectInterest(InterestProject $id){        

        $this->entityManager->remove($id);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('proposals-info');
    }

    public function deleteProfileInterest(InterestProfile $id){        

        $this->entityManager->remove($id);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('proposals-info');
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
