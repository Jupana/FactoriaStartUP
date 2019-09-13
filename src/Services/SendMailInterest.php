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

    /* ASTA E DIN DUETECH

    Asi es como la defines:
    
    $query = new GeneralQueries($this->getDoctrine()->getManager());

    Asa e cum o ceri :
    
    $portfolioByStatus = $query->getPortfolioByStatus($account->getId());

     public function __construct($em)
    {
        $this->em = $em;
    }
 
    public function getPortfolioByStatus ($accountId) {        
        try {            
            $query = "SELECT count(1) total, IF(p.status = '', 'na', p.status) status
                FROM property p
                WHERE p.account_id = :accountid
                GROUP BY p.status";            
            $stmt = $this->em->getConnection()->prepare($query);
            $stmt->bindParam('accountid', $accountId);
            $stmt->execute();
            $result = $stmt->fetchAll();
        } catch (Exception $e) {
            return 0;
        }
        
        return $result;
    }*/
}