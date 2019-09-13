<?php

namespace App\Services;

use App\Entity\Notification;
use App\Repository\NotificationRepository;

class Utils{

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function createNotify($user,$oldMessage,$newMessage){
        $notify =  new Notification();
        $notify->setUser($user);
        $notify->setType($oldMessage->getType());
        if($oldMessage->getType() == "project_interest")
            $notify->setInterestProject($oldMessage->getInterestProject());
        if($oldMessage->getType() == "profile_interest")
            $notify->setInterestProfil($oldMessage->getInterestProfil());
        $notify->setSeen(false);
        $notify->setMessageConv($newMessage);
        $notify->setTime(new \DateTime());
        
        return $notify;

    }

    
}