<?php

namespace App\Services;

use App\Repository\UserRepository;
use App\Repository\ProfileUserRepository;
use App\Repository\ProjectRepository;
use App\Repository\ProfilRepository;


class GetMatchProjects{

    private $projectRepository;
    private $profileUserRepository;
    private $profilRepository;


    public function __construct(ProjectRepository $projectRepository, ProfileUserRepository $profileUserRepository,ProfilRepository $profilRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->profileUserRepository =$profileUserRepository;
    }


    public function getMatch($userId, $projectId){
        $project = $this->projectRepository->find($projectId);
        $profile = $this->profileUserRepository->findBy(['user'=>$userId]);
        dump($userId,$project,$profile);
       
        
    }

}