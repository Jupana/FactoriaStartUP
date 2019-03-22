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


    public function indexProfile()
    {
        $html = $this->twig->render('profile/index.html.twig', [
            'profiles' => $this->profileUserRepository->findAll(),
            'opciones_sectores' => $this->sectorRepository->findAll(),
            'opciones_perfil' => $this->profilRepository->findAll() 
        ]);
        return new Response($html);
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
    public function edit(ProfileUser $ProfileUser, Request $request)
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
                'profile/add.html.twig',
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
    public function addProfile(Request $request)
    {
        $ProfileUser = new ProfileUser();
        $ProfileUser->setprofileDate(new \DateTime());
        $user=$this->getUser();
        $ProfileUser->setUser($user);

        $form = $this->formFactory->create(ProfileUserType::class, $ProfileUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($ProfileUser);
            $this->entityManager->flush();

            return $this->redirectToRoute('equipo');


        }
        return new Response(
            $this->twig->render(
                'profile/add.html.twig',
                ['form'=>$form->createView()]
            )
        );
   
    }
}
