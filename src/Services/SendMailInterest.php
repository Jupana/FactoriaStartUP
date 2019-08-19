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
        $message = (new \Swift_Message('Factoria Start Up: A '.ucfirst($mailInterestProject['userName'].' le interesa tu proyecto '.ucfirst($mailInterestProject['projectName']))))
        ->setFrom('liviuromania@gmail.com')
        ->setTo($mailInterestProject['ownerMail'])
        ->setBody(
            $this->templating->render(                
                'email/mailInterestProyect.html.twig',
                ['dataMail' => $mailInterestProject]),
                'text/html'               
        );
        $this->mailer->send($message);
    }

    public function sendMailProfil($mailInterestProfil){
        dump($mailInterestProfil);
        
        
        /** SEND USER MAIL */
        $message = (new \Swift_Message('Factoria Start Up: A '.ucfirst($mailInterestProfil['userName'].' le interesa tu perfil '.ucfirst($mailInterestProfil['profileName']->getName() ))))
        ->setFrom('liviuromania@gmail.com')
        ->setTo($mailInterestProfil['ownerMail'])
        ->setBody(
            $this->templating->render(                
                'email/mailInterestProfile.html.twig',
                ['dataMail' => $mailInterestProfil]),
                'text/html'               
        );
        $this->mailer->send($message);
    }
}