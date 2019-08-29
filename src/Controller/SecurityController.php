<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SecurityController  extends AbstractController
{   
    /**
    * @var \Twig_Environment
    */
    private $twig;

    public function  __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

     /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {  
          
        return new Response($this->twig->render
        ('security/login.html.twig', 
            [
                'last_username' => $authenticationUtils->getLastUsername(),
                'error'         => $authenticationUtils->getLastAuthenticationError()
            ]
        ));

      
    }

    /**
     * @Route("/login_success", name="login_success")
     */
    public function postLoginRedirectAction()
    {
        if ($this->getUser()->getRoles()[0] =='ROLE_ADMIN') {
            return $this->redirectToRoute('admin-projects');
        }else {
            return $this->redirectToRoute('user');
        }
    }
    

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
        // este controller no se ejecutará,
        // ya que la route se maneja por el sistema de seguridad
    }
}
