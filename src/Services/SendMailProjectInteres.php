<?php

namespace App\Services;


class SendMailProjectInteres{

    private $mailer;
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }
    
    public function mailSend($mailInterestProject){
        
        
        /** SEND USER MAIL */
        $message = (new \Swift_Message('Factoria Start Up - Bienvenido'))
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
}