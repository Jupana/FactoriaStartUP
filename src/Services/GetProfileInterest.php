<?php

namespace App\Services;

use App\Repository\ProfilRepository;
use App\Repository\ProjectRepository;
use App\Repository\ProfileUserRepository;
use App\Repository\NeedsProjectRepository;


class GetProfileInterest{

    private $projectRepository;
    private $profileUserRepository;
    private $profilRepository;
    private $needsProjectRepository;


    public function __construct(ProjectRepository $projectRepository, 
            ProfileUserRepository $profileUserRepository,
            ProfilRepository $profilRepository,
            NeedsProjectRepository $needsProjectRepository
            )
    {
        $this->projectRepository = $projectRepository;
        $this->profileUserRepository =$profileUserRepository;
        $this->needsProjectRepository= $needsProjectRepository;
    }


    public function getProfileInterest($userId, $projectId){        
        $profilesUser = $this->profileUserRepository->findBy(['user'=>$userId]);
        $needsProject = $this->needsProjectRepository->findBy(['needs_project'=>$projectId]);

        $arrNeedsProfileProject =[];
        $arrNeedsProfileProjectDeal=[];
        foreach( $needsProject as $profileNeeds){            
            array_push($arrNeedsProfileProject,$profileNeeds->getNeedsProfile());
            $arrNeedsProfileProjectDeal[$profileNeeds->getNeedsProfile()]['deal'] = $profileNeeds->getNeedsDeal();
            $arrNeedsProfileProjectDeal[$profileNeeds->getNeedsProfile()]['percent']= $profileNeeds->getNeedsPercent();
        }        
       
        $arrUserProfile =[];
        foreach( $profilesUser as $profileUser){         
            array_push($arrUserProfile,$profileUser->getProfil());
        }
        
        $arrMatchProfilee=[];
        foreach($arrUserProfile as $userProfile){
            if(in_array($userProfile,$arrNeedsProfileProject)){
                array_push($arrMatchProfilee,$userProfile);
            }
        }
        $arrResult['needsProfileProject'] = $arrNeedsProfileProject;
        $arrResult['profileProjectDeal'] = $arrNeedsProfileProjectDeal;
        $arrResult['usersProfiles'] = $arrUserProfile;
        $arrResult['matchProfile'] = $arrMatchProfilee;
       
        return $arrResult;

       


       
    }

}