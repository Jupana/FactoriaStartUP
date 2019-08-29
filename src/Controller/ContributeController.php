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

        $formAddContribute = $this->formFactory->create(ContributeType::class,$contribute);
        $formAddContribute = handleRequest($request);

        if($formAddContribute->isSubmitted() && $formAddContribute->isValid()){
            $this->entityManager->persist($contribute);
            $this->entityManager->flush($contribute);
        }

        return $this->render('modals/formProfile.html.twig',
            [
                'formAddContribute' =>$formAddContribute->createView(),
            
            ]
        );
    }


}