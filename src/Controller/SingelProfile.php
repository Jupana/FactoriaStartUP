<?php
namespace App\Controller;

use App\Entity\ProfileUser;
use App\Entity\User;
use App\Entity\Sector;
use App\Entity\Profil;
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
use App\Repository\ProfesionalProfileRepository;

class SingelProfile extends AbstractController
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
            \Twig_Environment $twig, 
            UserRepository $userRepository,
            ProfileUserRepository $profileUserRepository,
            FormFactoryInterface $formFactory,
            EntityManagerInterface $entityManager,
            FlashBagInterface $flashBag
        ) 
        {
            $this->twig = $twig;
            $this->userRepository = $userRepository;
            $this->profileUserRepository = $profileUserRepository;
            $this->formFactory = $formFactory;
            $this->entityManager = $entityManager;
            $this->flashBag = $flashBag;
        }
  

     /**
    * @Route ("/addProfileUser/{id}", name="addProfileUser")
    * @param Request $request 
    */
    public function addProfileUser(Request $request , $id=null)
    
    {
        $profileUser = new ProfileUser();
        $profileUser->setprofileDate(new \DateTime());
        $user=$this->getUser();
        $profileUser->setUser($user);
        
        $profileUser = !$id ? $profileUser : $this->profileUserRepository->find($id);
       
        $profileUserSector = new Sector();
        $profileUserProfil = new Profil();
        
        $profileUser->setSector($profileUserSector);
        $profileUser->setProfil($profileUserProfil);
        
        $formAddProfile = $this->formFactory->create(ProfileUserType::class, $profileUser);
        $formAddProfile->handleRequest($request);
        //return $formAddProfile->createView();
        dump($profileUser);
        return $this->render('modals/AddPerfil.html.twig',
            [
                'formAddProfile' =>$formAddProfile->createView()
            ]
        );      
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
}