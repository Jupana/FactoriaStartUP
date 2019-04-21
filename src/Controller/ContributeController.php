<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ContributeRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Request;
use App\Entity\Contribute;




class ContributeController extends AbstractController{

    /**
     * @var ContributeRepository;
     */
    private $contributeRepo;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    public function __construct( 
        ContributeRepository $contributeRepo, 
        FormFactoryInterface $formFactory, 
        EntityManagerInterface $entityManager
        )
        {
            $this->contibuteRepo = $contributeRepo;
            $this->formFactory = $formFactory;
            $this->entityManager = $entityManager;

        }

    public function addContribute(Request $request)
    {
        $contribute = new Contribute();
        $user =$this->getUser();

        $formAddContibuite = $this->formFactory->create(ContributeType::class,$contribute);
        $formAddContibuite = handleRequest($request);

        if($formAddContibuite->isSubmitted() && $formAddContibuite->isValid()){
            $this->entityManager->persist($contribute);
            $this->entityManager->flush($contribute);
        }

        return $this->render('modals/FormPerfil.html.twig',
            [
                'formAddContibuite' =>$formAddContibuite->createView(),
            
            ]
        );
    }


}