<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\Project;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;

class GetProyects{

    /**
     * 
     * var @ProjectRepository
     * */ 
    private $projectRepository;
    
    private $userRepository;
    
    /**
     * @param ProjectRepository $projects
     */

    public function __construct(ProjectRepository $projectRepository, UserRepository $userRepository)
    {    
        $this->projectRepository = $projectRepository;
        $this->userRepository =$userRepository;
    }

    public function listProyects($user,$sector=null, $km = null, $lat=0, $long=0){
        
        if($user){
            if($km==0){                    
                    $projects = $this->projectRepository->findAll() ;
            }elseif($sector == null){
                $projects = $this->projectRepository->findAll();
            }            
            else{
                    $usersProjectsByDistance = $this->userRepository->findByDistance($user->getLatitud(),$user->getLongitud(),$km);
                    $arrayUsersId =[];
                    foreach($usersProjectsByDistance as $item){
                        array_push($arrayUsersId,$item['id']);
                    }
                    $projects =$this->projectRepository->findBy(['user'=>$arrayUsersId,'project_sector'=>$sector]);
                }
                
                shuffle($projects);
            }        
        else{
                if($lat!= 0 && $long!=0){
                    $usersProjectsByDistance = $this->userRepository->findByDistance($lat,$long,$km);
                $arrayUsersId =[];
                foreach($usersProjectsByDistance as $item){
                    array_push($arrayUsersId,$item['id']);
                }
                $projects =$this->projectRepository->findBy(['user'=>$arrayUsersId,'project_sector'=>$sector]);
                shuffle($projects);
                }elseif($sector){
                    $projects =$this->projectRepository->findBy(['project_sector'=>$sector]);
                    shuffle($projects);  
                }
                else{
                    $projects = $this->projectRepository->findAll() ;
                    shuffle($projects);
                }
            }
        return $projects;
    }
}