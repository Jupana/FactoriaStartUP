<?php
namespace App\Controller;

use App\Entity\ProfileUser;
use App\Form\ProfileUserType;
use App\Repository\ProfileUserRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SingelProfileController extends AbstractController
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
    * @param Request $request 
    */
    public function addProfileUser(Request $request)
    {
        $profileUser = new ProfileUser();
        $profileUser->setprofileDate(new \DateTime());
        $user=$this->getUser();
        $profileUser->setUser($user);
        
        $formAddProfile = $this->formFactory->create(ProfileUserType::class, $profileUser);
        $formAddProfile->handleRequest($request);

        if ($formAddProfile->isSubmitted() && $formAddProfile->isValid()) {
            $this->entityManager->persist($profileUser);
            $this->entityManager->flush();
            return $this->redirectToRoute('user/professional-info');
        }
        return $this->render('modals/form-profile.html.twig',
            [
                'formProfile' =>$formAddProfile->createView(),
                'profileUser' =>$profileUser
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

        return $this->render('modals/form-profile.html.twig',
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

        //$profileUser = $this->profileUserRepository->find($id);
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

        $this->flashBag->add('notice', 'El Profile ha sido eliminado');
        
        return $this->redirectToRoute('user/professional-info');
    }
}