<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/user/message", name="message_user")
     */
    public function index()
    {
        return $this->render('message/user.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
}
