<?php

namespace App\Controller;


use App\Entity\NeedsProject;
use App\Entity\InterestProfile;
use App\Form\InterestProfileType;
use App\Entity\Notification;
use App\Entity\Message;
use App\Repository\UserRepository;
use App\Repository\ProfileUserRepository;
use App\Repository\ProfilRepository;
use App\Repository\SectorRepository;
use App\Repository\ProjectRepository;
use App\Repository\ProfesionalProfileRepository;
use App\Repository\NeedsProjectRepository;
use App\Repository\InterestProfileRepository;
use App\Repository\NotificationRepository;
use App\Repository\CoworkingRepository;
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
     
     /**
    * @var CoworkingRepository
    */
    private $coworkingRepository;

    public function __construct(
        \Twig_Environment $twig, ProfileUserRepository $profileUserRepository, ProfilRepository $profilRepository, SectorRepository $sectorRepository,
        FormFactoryInterface $formFactory,EntityManagerInterface $entityManager,ProfesionalProfileRepository $profesionalProfileRepository,ProjectRepository $projectRepository,NeedsProjectRepository $projectNeedsRepo,
        FlashBagInterface $flashBag,InterestProfileRepository $interestProfileRepository, UserRepository $userRepository, NotificationRepository $notificationRepository,CoworkingRepository $coworkingRepository
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
        $this->coworkingRepository = $coworkingRepository;  
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
               $coworking = $this->coworkingRepository->findOneBy(['id'=>$formAddInterestProfile->get('coworking')->getData()]);            
              
               if($dealToAdd != 'Tipo de acuerdo'){    //OTRA MERDA QUE TE VIENE DESDE EL DROP DOWN DEL PORFILE TYPE              
                
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
                'dealInterest'=>$dealToAdd != 'Tipo de acuerdo' ? $dealToAdd : $projectAllNeeds[0]->getNeedsDeal(),
                'percentInterest'=>$percentToAdd ?? $projectAllNeeds[0]->getNeedsPercent(),                
                'descriptionInterest'=>$interestProfile->getInterestDescription(),
                'coworking' =>$coworking
               ];                

               $sendMailProfileInterest->sendMailProfil($mailInterestProfile);
               
               $interestProfile->setInterestProfile($interestProfile->getInterestProfile());
               $interestProfile->setInterestDescription($interestProfile->getInterestDescription());
               $interestProfile->setCoworking($coworking);

                $userSenderId =$this->getUser()->getId();
                $userRecipientId=$profile[0]->getUser()->getId();
                $idConv = $userSenderId.'-'.$userRecipientId.'-'.rand(1000,10000000);

                $message = new Message();
                $message->setUserSender($this->getUser());
                $message->setUserRecipient($profile[0]->getUser());
                $message->setInterestProfil($interestProfile);  
                $message->setType('profile_interest');
                $message->setTime(new \DateTime());
                $message->setText($interestProfile->getInterestDescription());
                $message->setConversationId($idConv);
               
               
               $createNotification =  new Notification();
               $createNotification->setUser($userProfileOwner);
               $createNotification->setType('profile_interest');
               $createNotification->setInterestProfile($interestProfile);
               $createNotification->setSeen(false);
               $createNotification->setTime(new \DateTime());
               $createNotification->setMessageConv($message);

                $this->entityManager->persist($interestProfile);
                $this->entityManager->persist($message);
                $this->entityManager->persist($createNotification);
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
 
}
