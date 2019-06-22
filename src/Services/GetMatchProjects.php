<?php

namespace App\Services;

use App\Repository\ProfilRepository;
use App\Repository\ProjectRepository;
use App\Repository\ProfileUserRepository;
use App\Repository\NeedsProjectRepository;


class GetMatchProjects{

    private $projectRepository;
    private $profileUserRepository;
    private $needsProjectRepository;


    public function __construct(ProjectRepository $projectRepository, 
            ProfileUserRepository $profileUserRepository,
            NeedsProjectRepository $needsProjectRepository
            )
    {
        $this->projectRepository = $projectRepository;
        $this->profileUserRepository =$profileUserRepository;
        $this->needsProjectRepository= $needsProjectRepository;
    }


    public function getMatch($userId, $projectId){        
        $profilesUser = $this->profileUserRepository->findBy(['user'=>$userId]);
        $needsProject = $this->needsProjectRepository->findBy(['needs_project'=>$projectId]);

        $arrNeedsProfileProject =[];
        $arrNeedsProfileProjectDeal=[];
        dump($needsProject);
        foreach( $needsProject as $profileNeeds){            
            array_push($arrNeedsProfileProject,$profileNeeds->getNeedsPerfil());
            $arrNeedsProfileProjectDeal[$profileNeeds->getNeedsPerfil()]['deal'] = $profileNeeds->getNeedsDeal();
            $arrNeedsProfileProjectDeal[$profileNeeds->getNeedsPerfil()]['percent']= $profileNeeds->getNeedsPercent();
            $arrNeedsProfileProjectDeal[$profileNeeds->getNeedsPerfil()]['description']= $profileNeeds->getNeedsDescription();
        }        
       
        $arrUserProfile =[];
        foreach( $profilesUser as $profileUser){         
            array_push($arrUserProfile,$profileUser->getProfil());
        }
        
        $arrMatchPerfile=[];
        foreach($arrUserProfile as $userProfile){
            if(in_array($userProfile,$arrNeedsProfileProject)){
                array_push($arrMatchPerfile,$userProfile);
            }
        }
        $arrResult['needsProfileProject'] = $arrNeedsProfileProject;
        $arrResult['profileProjectDeal'] = $arrNeedsProfileProjectDeal;
        $arrResult['usersProfiles'] = $arrUserProfile;
        $arrResult['matchProfile'] = $arrMatchPerfile;
       
        return $arrResult;

       


       
    }

}