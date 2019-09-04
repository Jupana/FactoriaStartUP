<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    

    private $messageRepository;

    public function __construct(Messagerepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }
    
   
    public function listMessages()
    {   
        $userMessages = $this->messageRepository->findMessage($this->getUser()->getId());
        $message = $this->messageRepository->findAll();
        return $this->render('messages/list.html.twig', [
            'userMessages' => $userMessages,
            'message' => $message
        ]);
    }

  
    public function message($id)
    {   
        $userMessages = $this->messageRepository->findMessage($this->getUser()->getId());
        $message = $this->messageRepository->findBy(['conversation_id' =>$id]);
        return $this->render('messages/message.html.twig', [
            'userMessages' => $userMessages,
            'message' => $message,
        ]);
    }
}
