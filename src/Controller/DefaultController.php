<?php
namespace App\Controller;
use App\Repository\ProjectRepository;
use App\Services\GetProfile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProjectRepository $projects, GetProfile $profiles): Response
    {
            
        $projects = $projects->findAll() ;
        \shuffle($projects);
        $projects = array_slice($projects,0,6); 
        
        $profiles=$profiles->listProfile($this->getUser());
        
        $html = $this->render('default/index.html.twig', [
            'projects' => $projects, 
            'profiles'=>$profiles           
        ]);

        return new Response($html->getContent());
    }
}