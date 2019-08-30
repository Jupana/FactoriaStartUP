<?php

namespace App\Controller;


use App\Entity\NeedsProject;
use App\Entity\ProfileUser;
use App\Entity\InterestProfile;
use App\Form\InterestProfileType;
use App\Entity\Notification;
use App\Repository\UserRepository;
use App\Repository\ProfileUserRepository;
use App\Repository\ProfilRepository;
use App\Repository\SectorRepository;
use App\Repository\ProjectRepository;
use App\Repository\ProfesionalProfileRepository;
use App\Repository\NeedsProjectRepository;
use App\Repository\InterestProfileRepository;
use App\Repository\NotificationRepository;
use App\Services\GetProfile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\SendMailInterest;




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

    /**
    * @var NeedsProjectRepository
    */
    private $projectNeedsRepo;

    /**
     * @var InterestProfileRepository
     */

     private $interestProfileRepository;


     /**
      * @var UserRepository
      */

     private $userRepository; 

     /**
      * @var NotificationRepository       
      */

      private $notificationRepository;
     


    public function __construct(
        \Twig_Environment $twig, ProfileUserRepository $profileUserRepository, ProfilRepository $profilRepository, SectorRepository $sectorRepository,
        FormFactoryInterface $formFactory,EntityManagerInterface $entityManager,ProfesionalProfileRepository $profesionalProfileRepository,ProjectRepository $projectRepository,NeedsProjectRepository $projectNeedsRepo,
        FlashBagInterface $flashBag,InterestProfileRepository $interestProfileRepository, UserRepository $userRepository, NotificationRepository $notificationRepository
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
        $this->projectNeedsRepo = $projectNeedsRepo;
        $this->interestProfileRepository = $interestProfileRepository;
        $this->userRepository = $userRepository;
        $this->notificationRepository =$notificationRepository;
    }


    public function indexProfile(GetProfile $profiles)
    {
            $profiles=$profiles->listProfile($this->getUser());
            $html = $this->twig->render('profile/index.html.twig', [
                'profiles' => $profiles,
                'opciones_sectores' => $this->sectorRepository->findAll(),
                'opciones_Profile' => $this->profilRepository->findAll()
            ]);
            return new Response($html); 
       
    }
   
    public function indexProfileFilter(GetProfile $listProfiles, $profiles, $km,$lat,$long)
    {           
            $listProfiles = $listProfiles->listProfile($this->getUser(),$profiles,$km,$lat,$long);
            $html = $this->twig->render('profile/index.html.twig', [
                'profiles' => $listProfiles,
                'opciones_sectores' => $this->sectorRepository->findAll(),
                'opciones_Profile' => $this->profilRepository->findAll() 
            ]);
            return new Response($html);
    } 

    public function profile(Request $request, $id, SendMailInterest $sendMailProfileInterest)
    {
        $profile = $this->profileUserRepository->findBy(['user' =>$id]);
        $projects = $this->projectRepository->findBy(['user' =>$id]);
        $profilesInterest = $this->interestProfileRepository->findBy(['user'=>$this->getUser(),'user_profile_owner'=>$id]);

        
        
      
        //This don't make sense you have to add it to USER Entity, i mean Prosfesional Repository
        $profesional = $this->profesionalProfileRepository->findOneBy(['profesionalIdUser' =>$id]);
        
        if($this->getUser()){
            $distanceUsers = $this->distance($this->getUser()->getLatitud(), $this->getUser()->getLongitud(),$profile[0]->getUser()->getLatitud(), $profile[0]->getUser()->getLongitud());
        }else{
            $distanceUsers='0.0';
        }

        if($this->getuser()){
            $userProfileOwner = $this->userRepository->find(['id'=>$id]);            
            $interestProfile = new InterestProfile();            
            $interestProfile->setUser($this->getUser());
            $interestProfile->setUserProfileOwner($userProfileOwner);
            $interestProfile->setInterestDate(new \DateTime()); 
            $interestProfile->setInterestStatus(false);          
            
            $formAddInterestProfile = $this->formFactory->create(InterestProfileType::class, $interestProfile,['userId'=> $this->getuser()->getId(),'profileUserId'=>$id]);
            
            $formAddInterestProfile->handleRequest($request);

            if ($formAddInterestProfile->isSubmitted() && $formAddInterestProfile->isValid()) {
           
               $dealToAdd = $formAddInterestProfile->get('extra_profil_deal_add')->getData();
               $percentToAdd = $formAddInterestProfile->get('extra_profil_percent_add')->getData();                              
               $projectAllNeeds = $this->projectNeedsRepo->findBy(['needs_project'=>$interestProfile->getInterestProject()->getId()]);                
               
               if($dealToAdd != NULL){                 
                
                $newProfileAddFromMatch = new NeedsProject();
                $newProfileAddFromMatch->setUser($this->getuser());
                $newProfileAddFromMatch->setNeedsIdProject($interestProfile->getInterestProject());
                $newProfileAddFromMatch->setNeedsProfile($interestProfile->getInterestProfile());
                
                $newProfileAddFromMatch->setNeedsDescription($interestProfile->getInterestDescription() );
                $newProfileAddFromMatch->setNeedsDeal($dealToAdd);
                $newProfileAddFromMatch->setNeedsPercent($percentToAdd); 

                $newProfileAddFromMatch->setNeedsDate(new \DateTime());
                $this->entityManager->persist($newProfileAddFromMatch);                                
               }
                    
               

               $mailInterestProfile =[
                'userName'=>$this->getUser()->getUsername(),
                'userMail' =>$this->getUser()->getEmail(),
                'ownerName'=>$profile[0]->getUser()->getUsername(),
                'ownerMail' =>$profile[0]->getUser()->getEmail(),
                'profileName' =>$interestProfile->getInterestProfile(),
                'projectInterest'=>$interestProfile->getInterestProject(),
                'dealInterest'=>$dealToAdd ?? $projectAllNeeds[0]->getNeedsDeal(),
                'percentInterest'=>$percentToAdd ?? $projectAllNeeds[0]->getNeedsPercent(),                
                'descriptionInterest'=>$interestProfile->getInterestDescription(),
               ];                

               $sendMailProfileInterest->sendMailProfil($mailInterestProfile);
               
               $interestProfile->setInterestProfile($interestProfile->getInterestProfile());
               $interestProfile->setInterestDescription($interestProfile->getInterestDescription());

               $createNotifiation =  new Notification();
               $createNotifiation->setUser($userProfileOwner);
               $createNotifiation->setType('profile_interest');
               $createNotifiation->setEntity($interestProfile->getInterestProfile()->getId());
               $createNotifiation->setInterestProfile($interestProfile);
               $createNotifiation->setSeen(false);
               $createNotifiation->setTime(new \DateTime());

                $this->entityManager->persist($interestProfile);
                $this->entityManager->persist($createNotifiation);
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
                        'formInterestProfile' =>$formAddInterestProfile->createView(),
                        'profilesInterest'=>$profilesInterest,                        
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

    private function distance($lat1, $lon1, $lat2, $lon2) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $km  = $miles * 1.609344;

        return round( number_format ($km,2) , 1, PHP_ROUND_HALF_UP );
    }
    
    
    public function notificationCount($id){
        $user = $this->userRepository->find(['id'=>$id]);        
        $allNotifications = $user->getNotifications()->getValues();
        
        foreach($allNotifications as $notification){
            $result['values'][$notification->getId()]['id'] = $notification->getId();
            $result['values'][$notification->getId()]['type'] = $notification->getType();
            $result['values'][$notification->getId()]['entity'] = $notification->getEntity();
            $result['values'][$notification->getId()]['seen'] = $notification->getSeen();
            $result['values'][$notification->getId()]['time'] = $notification->getTime()->format('H:i:s');
            if($notification->getInterestProfile() !== null){
                $profile = $notification->getInterestProfile();
                $idP=$profile->getId();
                $result['values'][$notification->getId()]['profile_interest'][$idP]['id'] = $idP;
                $result['values'][$notification->getId()]['profile_interest'][$idP]['user']=$profile->getUser()->getName();
                $result['values'][$notification->getId()]['profile_interest'][$idP]['interest_description']=$profile->getInterestDescription();
                $result['values'][$notification->getId()]['profile_interest'][$idP]['interest_profile']=$profile->getInterestProfile()->getName();
                $result['values'][$notification->getId()]['profile_interest'][$idP]['interest_project']=$profile->getInterestProject()->getProjectName();

            }

            
        }
        
        $result['not_count'] = $user->getNotifications()->count();


        return new Response(json_encode($result));
        
    }
 
}
