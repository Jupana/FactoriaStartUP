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
    public function index_vista(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/index_vista.html.twig');
    }
    public function datos_personales(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/datos_Personales.html.twig');
    }
    public function datos_profesionales(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/datos_Profesionales.html.twig');
    }
    public function datos_proyectos(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/datos_Proyectos.html.twig');
    }
    public function añadir_proyecto(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/añadir_proyecto.html.twig');
    }
    public function datos_propuestas(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/datos_Propuestas.html.twig');
    }
    public function datos_cuenta(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('vista_usuario/datos_Cuenta.html.twig');
    }
}