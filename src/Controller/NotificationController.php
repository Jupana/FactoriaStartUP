<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class NotificationController extends AbstractController
{
    /**
     * @var NotificationRepository
     */

    public $repoNotification;

    public function __construct(NotificationRepository $repoNotification )
    {
        $this->repoNotification = $repoNotification;
        
    }


    public function showNotification()
    {
        
        $user = $this->getUser();
        $results =[];
        
        if($user){
            $countNotify = $this->repoNotification->countNotify($user->getId());
            $allNotifications = $user->getNotifications()->getValues();
            
            rsort($allNotifications);//We resort this array to have the last notification like firrst one
            foreach($allNotifications as $notification){
                $results['values'][$notification->getId()]['id'] = $notification->getId();
                $results['values'][$notification->getId()]['type'] = $notification->getType();
                $results['values'][$notification->getId()]['seen'] = $notification->getSeen();
                $results['values'][$notification->getId()]['message_conv'] = $notification->getMessageConv() != null ? $notification->getMessageConv()->getConversationId():3;
                
                if($notification->getInterestProfile() !== null){
                    $profile = $notification->getInterestProfile();
                    $idP=$profile->getId();
                    $results['values'][$notification->getId()]['profile_interest'][$idP]['id'] = $idP;
                    $results['values'][$notification->getId()]['profile_interest'][$idP]['user']=$profile->getUser()->getName();
                    $results['values'][$notification->getId()]['profile_interest'][$idP]['user_image']=$profile->getUser()->getProfileImg();
                    $results['values'][$notification->getId()]['profile_interest'][$idP]['interest_description']=$profile->getInterestDescription();
                    $results['values'][$notification->getId()]['profile_interest'][$idP]['interest_profile']=$profile->getInterestProfile()->getName();                    
                    $results['values'][$notification->getId()]['profile_interest'][$idP]['time'] = $notification->getTime()->format('d-m-Y');
                }

                if($notification->getInterestProject() !== null){
                    $project = $notification->getInterestProject();
    
                    $idP=$project->getId();
                    $results['values'][$notification->getId()]['project_interest'][$idP]['id'] = $idP;
                    $results['values'][$notification->getId()]['project_interest'][$idP]['user']=$project->getInterestIdUser()->getName();
                    $results['values'][$notification->getId()]['project_interest'][$idP]['user_image']=$project->getInterestIdUser()->getProfileImg();
                    $results['values'][$notification->getId()]['project_interest'][$idP]['interest_description']=$project->getInterestDescription();                    
                    $results['values'][$notification->getId()]['project_interest'][$idP]['interest_project']=$project->getInterestIdProject()->getProjectName();
                    $results['values'][$notification->getId()]['project_interest'][$idP]['time'] = $notification->getTime()->format('d-m-Y');
                } 
            }
            
           $results['count_notify'] = $countNotify; 
            return $this->render('nav_bar/nav_bar.html.twig', [
                'results' => $results,
                'allNotifications'=> $allNotifications
            ]);            
        }
        return $this->render('nav_bar/nav_bar.html.twig');
        
    }

    public function upDateNotify($id){
        $notify = $this->repoNotification->findOneBy(['id'=>$id]);

        $notify->setSeen(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($notify);        
        $entityManager->flush();
        return new JsonResponse(['result' => 'OK']);

    }
}
