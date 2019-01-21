<?php
namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/")
 */
class VistaUsuarioController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/index.html.twig');
    }
}