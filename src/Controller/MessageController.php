<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Entity\Message;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

  
    public function message($id,Request $request)
    {   
        $userMessages = $this->messageRepository->findMessage($this->getUser()->getId());
        $message = $this->messageRepository->findBy(['conversation_id' =>$id]);

        $newMessage = new Message();
        $form = $this->createForm(
            MessageType::class,
            $newMessage
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {        
            $conversation_id = $newMessage->getConversationId();
            $type = $newMessage->getType();
            $text = $newMessage->getText();
            $time = $newMessage->setTime(new \DateTime());
            $user_sender = $newMessage->getUserSender();
            $user_recipient = $newMessage->getUserRecipient();
            $interest_project = $newMessage->getInterestProject();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newMessage);
            $entityManager->flush();

            return $this->redirectToRoute('list-messages');
        }

        return $this->render('messages/message.html.twig', [
            'userMessages' => $userMessages,
            'message' => $message,
            'form' => $form->createView()
        ]);
    }
}
