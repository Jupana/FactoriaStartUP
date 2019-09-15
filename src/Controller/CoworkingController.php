<?php

namespace App\Controller;

use App\Entity\Coworking;
use App\Form\CoworkingType;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use App\Repository\CoworkingRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NeedsProjectRepository;
use App\Repository\ContributeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;




class CoworkingController extends AbstractController
{   
    /**
    * @var \Twig_Environment
    */
    private $twig;

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
    * @var NeedRepository
    */
    private $needsRepository;

    /**
    * @var ContributeRepository
    */
    private $contributeRepository;

    /**
    * @var CoworkingRepository
    */
    private $coworkingRepository;

    /**
    * @var FlashBagInterface
    */
    private $flashBag;

    public function __construct(
        \Twig_Environment $twig, 
        ProjectRepository $projectRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,        
        UserRepository $userRepository,
        NeedsProjectRepository $needsRepository,
        ContributeRepository $contributeRepository,
        CoworkingRepository $coworkingRepository,
        FlashBagInterface $flashBag
        ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
        $this->userRepository =$userRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;  
        $this->needsRepository = $needsRepository;  
        $this->contributeRepository = $contributeRepository; 
        $this->coworkingRepository = $coworkingRepository;  
        $this->flashBag = $flashBag;  
    }
  
   
    public function coworking($id, Request $request)
    {
        
        $newCoWorking = $id == 'new' ? new Coworking(): $this->coworkingRepository->findOneBy(['id'=>$id]);
        
        $formNewCoWorking = $this->formFactory->create(CoworkingType::class, $newCoWorking);
        $formNewCoWorking->handleRequest($request);
  
        if ($formNewCoWorking->isSubmitted() && $formNewCoWorking->isValid()) {        
            $newCoWorking->setDate(new \DateTime());
            if($formNewCoWorking['img']->getData()){
                $file = $formNewCoWorking['img']->getData();
                $fileName = $formNewCoWorking['name']->getData().'-'.md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('imgCoworking'), $fileName);
            $newCoWorking->setImg($fileName);
            
            }    
                
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newCoWorking);
            $entityManager->flush();

            return $this->redirectToRoute('admin-coworking-list');
        }

        return $this->render('admin/coworking.html.twig',[
            'form' => $formNewCoWorking->createView()
        ]);

    }


    public function listCoworking()
    {
        $coworkingList = $this->coworkingRepository->findAll();
      
        return new Response(
            $this->twig->render(
                'admin/coworking-list.html.twig',
                [
                    'coworkingList' => $coworkingList                        
                ]
            )
        ); 
    }

    public function listCoworkingJson($id)
    {
        $coworking = $this->coworkingRepository->find($id);
       
        $coworking = $this->get('serializer')->serialize($coworking, 'json');
        return new Response($coworking );
    }

    public function deleteCoworking( int $id)
    {
        $coworking = $this->coworkingRepository->find($id);

        
        $this->entityManager->remove($coworking);
        $this->entityManager->flush();

        $this->flashBag->add('notice', 'El Coworking ha sido eliminado');
        
        return $this->redirectToRoute('admin-coworking-list');
    }


    public function listCoworkingFree()
    {
        $coworkingList = $this->coworkingRepository->findAll();
      
        return new Response(
            $this->twig->render(
                'coworking/index.html.twig',
                [
                    'coworkingList' => $coworkingList                        
                ]
            )
        ); 
    }
}
