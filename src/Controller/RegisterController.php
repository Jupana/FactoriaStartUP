<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     */
    public function register(UserPasswordEncoderInterface $passwordEncoder,Request $request, \Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(
            UserRegisterType::class,
            $user
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($password);
            
            $name = $user->getUsername();
            $email =$user->getEmail();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            /** SEND USER MAIL */
        //     $message = (new \Swift_Message('Factoria Start Up - Bienvenido'))
        //     ->setFrom('liviuromania@gmail.com')
        //     ->setTo($email)
        //     ->setBody(
        //             $this->renderView(
        //             // templates/emails/registration.html.twig
        //             'email/registration.html.twig',
        //             ['name' => $name]),
        //             'text/html'               
        //     );

        // $mailer->send($message);


            return $this->redirectToRoute('security_login');
        }

        return $this->render('register/register.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
