<?php

namespace App\Services;


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
        //ESTO ES UNA MIERDA hABrA QUE HACERLO DE NUEVO
        $projectByTxt= $this->projectRepository->findOneBy(['project_name'=>$projectId]);
        
        $needsProject = $this->needsProjectRepository->findBy(['needs_project'=>$projectId]);
        $needsProject = $needsProject !=null ? $needsProject: $this->needsProjectRepository->findBy(['needs_project'=>$projectByTxt->getId()]);
    
        $arrNeedsProfileProject =[];
        $arrNeedsProfileProjectDeal=[];        
        foreach( $needsProject as $profileNeeds){ 
                       
            array_push($arrNeedsProfileProject,$profileNeeds->getNeedsProfile()->getName());
            $arrNeedsProfileProjectDeal[$profileNeeds->getNeedsProfile()->getName()]['deal'] = $profileNeeds->getNeedsDeal();
            $arrNeedsProfileProjectDeal[$profileNeeds->getNeedsProfile()->getName()]['percent']= $profileNeeds->getNeedsPercent();
            $arrNeedsProfileProjectDeal[$profileNeeds->getNeedsProfile()->getName()]['description']= $profileNeeds->getNeedsDescription();
        }        
       
        $arrUserProfile =[];
        foreach( $profilesUser as $profileUser){         
            array_push($arrUserProfile,$profileUser->getProfil()->getName());
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