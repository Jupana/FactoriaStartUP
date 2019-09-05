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

        $user = $this->getUser();
        $userSender = $message[0]->getUserSender();
        $userRecipient = $message[0]->getUserRecipient();

        $userRecipient = $user->getId() == $userRecipient->getId() ? $userSender : $userRecipient;
        
        $newMessage = new Message();
        $newMessage-> setType($message[0]->getType());
        $newMessage->setConversationId($message[0]->getConversationId());
        $newMessage->setUserSender($user);
        $newMessage->setUserRecipient($userRecipient);
        
        if($message[0]->getType() == "project_interest")
            $newMessage->setInterestProject($message[0]->getInterestProject());
        if($message[0]->getType() == "profile_interest")
            $newMessage->setInterestProfil($message[0]->getInterestProfil());
        
        $form = $this->createForm(
            MessageType::class,
            $newMessage
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {        
            $newMessage->setTime(new \DateTime());
            
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
