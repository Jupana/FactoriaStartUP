<?php

namespace App\Controller;

use App\Entity\ProfileUser;
use App\Entity\User;
use App\Form\ProfileUserType;
use App\Repository\ProfileUserRepository;
use App\Repository\ProfilRepository;
use App\Repository\SectorRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        FormFactoryInterface $formFactory,EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag
        ) {
        $this->twig = $twig;
        $this->profileUserRepository = $profileUserRepository;
        $this->sectorRepository = $sectorRepository;
        $this->profilRepository = $profilRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }


    public function indexProfile(Request $request)
    {
       
            $html = $this->twig->render('profile/index.html.twig', [
                'profiles' => $this->profileUserRepository->findAll(),
                'opciones_sectores' => $this->sectorRepository->findAll(),
                'opciones_perfil' => $this->profilRepository->findAll(),
                'form_addProfile'=>$this->addProfile($request)
            ]);
            return new Response($html); 
       
    }


    /**
    * @Route ("/addPerfil", name="addPerfil", methods={"POST,GET"})
    * @param Request $request    * 
    */
    public function addProfile(Request $request )
    
    {
        $ProfileUser = new ProfileUser();
        $ProfileUser->setprofileDate(new \DateTime());
        $user=$this->getUser();
        $ProfileUser->setUser($user);
        
        $form = $this->formFactory->create(ProfileUserType::class, $ProfileUser);
        $form->handleRequest($request);
        return $form->createView();
        
    }

    /**
    * @Route ("/add_perfil_update", name="addPerfilUpdate", methods={"POST,GET"}, options={"expose"=true})
    * @param Request $request
    * @param int
    * @return JsonResponse
    */
    public function addProfileUpdate(Request $request )
    
    {
        $ProfileUser = new ProfileUser();
        $ProfileUser->setprofileDate(new \DateTime());
        $user=$this->getUser();
        $ProfileUser->setUser($user);
        
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


    public function profile($id)
    {
        $profile = $this->profileUserRepository->find($id);

        return new Response(
            $this->twig->render(
                'profile/profile.html.twig',
                [
                    'profile' => $profile
                ]
            )
        );
    }
    
    public function editProfile(ProfileUser $ProfileUser, Request $request)
    {
        
        $form = $this->formFactory->create(ProfileUserType::class, $ProfileUser);
        $form->handleRequest($request);
        $ProfileUser->setProfileDate(new \DateTime());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($ProfileUser);
            $this->entityManager->flush();

            return $this->redirectToRoute('equipo');


        }
        return new Response(
            $this->twig->render(
                'modals/AddPerfil.html.twig',
                ['form'=>$form->createView()]
            )
        );
    }

    public function delete(ProfileUser $ProfileUser)
    {
        $this->entityManager->remove($ProfileUser);
        $this->entityManager->flush();

        $this->flashBag->add('notice', 'El perfil ha sido eliminado');
        
        return $this->redirectToRoute('equipo');
    }
   
}
