<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\NeedsProject;
use App\Entity\ProfileUser;
use App\Entity\InterestProfile;
use App\Form\InterestProfileType;
use App\Repository\ProfileUserRepository;
use App\Repository\ProfilRepository;
use App\Repository\SectorRepository;
use App\Repository\ProjectRepository;
use App\Repository\ProfesionalProfileRepository;
use App\Services\GetProfile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class ProfileUserController extends AbstractController
{   
    /**
    * @var \Twig_Environment
    */
    private $twig;

    /**
    * @var sectorRepository
    */
    private $sectorRepository;

    /**
    * @var profilRepository
    */
    private $profilRepository;

    /**
    * @var profesionalProfileRepository
    */
    private $profesionalProfileRepository;

    /**
    * @var projectRepository
    */
    private $projectRepository;

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
        \Twig_Environment $twig, ProfileUserRepository $profileUserRepository, ProfilRepository $profilRepository, SectorRepository $sectorRepository,
        FormFactoryInterface $formFactory,EntityManagerInterface $entityManager,ProfesionalProfileRepository $profesionalProfileRepository,ProjectRepository $projectRepository,
        FlashBagInterface $flashBag
        ) {
        $this->twig = $twig;
        $this->profileUserRepository = $profileUserRepository;
        $this->sectorRepository = $sectorRepository;
        $this->profilRepository = $profilRepository;
        $this->projectRepository = $projectRepository;
        $this->profesionalProfileRepository = $profesionalProfileRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }


    public function indexProfile(GetProfile $profiles)
    {
            $profiles=$profiles->listProfile($this->getUser());
            $html = $this->twig->render('profile/index.html.twig', [
                'profiles' => $profiles,
                'opciones_sectores' => $this->sectorRepository->findAll(),
                'opciones_perfil' => $this->profilRepository->findAll()
            ]);
            return new Response($html); 
       
    }
   
    public function indexProfileFilter(GetProfile $listProfiles, $profiles, $km,$lat,$long)
    {           
            $listProfiles = $listProfiles->listProfile($this->getUser(),$profiles,$km,$lat,$long);
            $html = $this->twig->render('profile/index.html.twig', [
                'profiles' => $listProfiles,
                'opciones_sectores' => $this->sectorRepository->findAll(),
                'opciones_perfil' => $this->profilRepository->findAll() 
            ]);
            return new Response($html);
    } 

    public function profile(Request $request, $id)
    {
        $profile = $this->profileUserRepository->findBy(['user' =>$id]);
        $projects = $this->projectRepository->findBy(['user' =>$id]);
      
        //This don't make sense you have to add it to USER Entity, i mean Prosfesional Repository
        $profesional = $this->profesionalProfileRepository->findOneBy(['profesionalIdUser' =>$id]);

        
        
        
        $distanceUsers = $this->distance($this->getUser()->getLatitud(), $this->getUser()->getLongitud(),$profile[0]->getUser()->getLatitud(), $profile[0]->getUser()->getLongitud());
      

        if($this->getuser()){
            $interestProfile = new InterestProfile();

            $interestProfile->setUser($this->getUser());
            $interestProfile->setUserProfileOwner($id);
            $interestProfile->setInterestDate(new \DateTime()); 
            $interestProfile->setInterestStatus(false);          
           
            
            $formAddInterestProfile = $this->formFactory->create(InterestProfileType::class, $interestProfile,['userId'=> $this->getuser()->getId(),'profileUserId'=>$id]);
            $formAddInterestProfile->handleRequest($request);
    
            if ($formAddInterestProfile->isSubmitted() && $formAddInterestProfile->isValid()) {

               $dealToAdd = $formAddInterestProfile->get('extra_profil_deal_add')->getData();
               $percentToAdd = $formAddInterestProfile->get('extra_profil_percent_add')->getData();

               if($dealToAdd != NULL){
                 //Otra Mierda, si tiens tiempo tienes que reescribir esto:
                $getIdProfile = $this->profilRepository->findBy(['name'=>$interestProfile->getInterestProfile()]);
                $projectToUpdate = $this->projectRepository->find($interestProfile->getInterestProject());
                
                $newProfileAddFromMatch = new NeedsProject();
                $newProfileAddFromMatch->setUser($this->getuser());
                $newProfileAddFromMatch->setNeedsIdProject($projectToUpdate);
                $newProfileAddFromMatch->setNeedsPerfil($getIdProfile[0]->getName());
                
                $newProfileAddFromMatch->setNeedsDescription($interestProfile->getInterestDescription() );
                $newProfileAddFromMatch->setNeedsDeal($dealToAdd);
                $newProfileAddFromMatch->setNeedsPercent($percentToAdd); 

                $newProfileAddFromMatch->setNeedsDate(new \DateTime());
                $this->entityManager->persist($newProfileAddFromMatch);                
               }
                
               //Otra Mierda transformas el Profil name to ID
                $interestProfile->setInterestProfile($getIdProfile[0]->getId());
                $this->entityManager->persist($interestProfile);
                $this->entityManager->flush();   
                
                $this->flashBag->add('notice', 'Mensaje Enviado');
            }

    
            return new Response(
                $this->twig->render(
                    'profile/profile.html.twig',
                    [
                                          
                        'profile' => $profile,
                        'distanceUsers'=>$distanceUsers,
                        'projects' =>$projects, 
                        'profesional'=>$profesional, 
                        'formInterestProfile' =>$formAddInterestProfile->createView()
                    ]
                )
            );
        }else{
            return new Response(
                $this->twig->render(
                    'profile/profile.html.twig',
                    [
                        'profile' => $profile,
                        'distanceUsers'=>$distanceUsers,
                        'projects' =>$projects,                       
                        'profesional'=>$profesional
                    ]
                )
            );
        }
       
    }
    
    public function delete(ProfileUser $ProfileUser)
    {
        $this->entityManager->remove($ProfileUser);
        $this->entityManager->flush();

        $this->flashBag->add('notice', 'El perfil ha sido eliminado');
        
        return $this->redirectToRoute('profiles');
    }
   


    private function distance($lat1, $lon1, $lat2, $lon2) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $km  = $miles * 1.609344;

        return round( number_format ($km,2) , 1, PHP_ROUND_HALF_UP );
    }  
}
