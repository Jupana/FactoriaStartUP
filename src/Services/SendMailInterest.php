<?php

namespace App\Services;


class SendMailInterest{

    private $mailer;
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }
    
    public function sendMailProject($mailInterestProject){
        
        
        /** SEND USER MAIL */
        $message = (new \Swift_Message('Factoria Start Up: A '.ucfirst($mailInterestProject['userName'].' le interesa tu project '.ucfirst($mailInterestProject['projectName']))))
        ->setFrom('liviuromania@gmail.com')
        ->setTo($mailInterestProject['ownerMail'])
        ->setBody(
            $this->templating->render(                
                'email/mail-Interest-project.html.twig',
                ['dataMail' => $mailInterestProject]),
                'text/html'               
        );
        $this->mailer->send($message);
    }

    public function sendMailProfil($mailInterestProfil){
        
        
        /** SEND USER MAIL */
        $message = (new \Swift_Message('Factoria Start Up: A '.ucfirst($mailInterestProfil['userName'].' le interesa tu profile '.ucfirst($mailInterestProfil['profileName']->getName() ))))
        ->setFrom('liviuromania@gmail.com')
        ->setTo($mailInterestProfil['ownerMail'])
        ->setBody(
            $this->templating->render(                
                'email/mail-Interest-profile.html.twig',
                ['dataMail' => $mailInterestProfil]),
                'text/html'               
        );
        $this->mailer->send($message);
    }

    public function sendMailMessage($mailMessage){
        /** SEND USER MAIL */
        $message = (new \Swift_Message('Factoria Start Up: Tienes un nuveo mensaje de  '.ucfirst($mailMessage['userName'])))
        ->setFrom('liviuromania@gmail.com')
        ->setTo($mailMessage['ownerMail'])
        ->setBody(
            $this->templating->render(                
                'email/mail-message.html.twig',
                ['dataMail' => $mailMessage]),
                'text/html'               
        );
        $this->mailer->send($message);
    }
}