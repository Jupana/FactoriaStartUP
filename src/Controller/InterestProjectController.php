<?php
namespace App\Controller;


use App\Repository\ProfilRepository;
use App\Repository\SectorRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/")
 */
class InterestProjectController extends Controller
{
    
    /**
     * @var ProfilRepository
     */
    private $profilRepository;

    /**
     * @var SectorRepository
     */
    private $sectorRepository;

    public function __construct(ProfilRepository $profilRepository, SectorRepository $sectorRepository)
    {
        $this->profilRepository = $profilRepository;
        $this->sectorRepository = $sectorRepository;
    } 
    
    public function interestSelectPerfil(Request $request): Response
    {
        $profileRepo = $this->profilRepository->findAll();
        
        return $this->render('modals/selectPerfil.html.twig',
            [
                'profileList' => $profileRepo
            ]
        );
    }

    public function interestSelectSectorDeal(Request $resquest): Response
    {
        $sectorRepo = $this->sectorRepository->findAll();
        
        return $this->render('modals/addInterestProyect.html.twig',
            [
                'sectorList' => $sectorRepo
            ]
        );  
    }
}