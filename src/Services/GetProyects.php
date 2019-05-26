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

    public function listProyects($user,$sector=0, $km = null, $lat=0, $long=0){
        
        if($user){
            
                    if($sector == 0 && $km != 0){
                        $usersProjectsByDistance = $this->userRepository->findByDistance($user->getLatitud(),$user->getLongitud(),$km);
                        $arrayUsersId =[];
                        foreach($usersProjectsByDistance as $item){
                            array_push($arrayUsersId,$item['id']);
                        }
                        $projects =$this->projectRepository->findBy(['user'=>$arrayUsersId]);
                        
                    }
                    elseif($sector != 0 && $km != 0){
                        $usersProjectsByDistance = $this->userRepository->findByDistance($user->getLatitud(),$user->getLongitud(),$km);
                        $arrayUsersId =[];
                        foreach($usersProjectsByDistance as $item){
                            array_push($arrayUsersId,$item['id']);
                        }
                        $projects =$this->projectRepository->findBy(['user'=>$arrayUsersId,'project_sector'=>$sector]);               
                    }
                    elseif($sector != 0 && $km == 0){
                        $projects =$this->projectRepository->findBy(['project_sector'=>$sector]);                 
                    }
                    else{                                 
                            $projects = $this->projectRepository->findAll() ;
                    }
                    
                }          
  
                    /* THIS SI WEHN YOU DON?T HAVE LAT AND LONG FROM THE URL
                    $usersProjectsByDistance = $this->userRepository->findByDistance($user->getLatitud(),$user->getLongitud(),$km);
                    $arrayUsersId =[];
                    foreach($usersProjectsByDistance as $item){
                        array_push($arrayUsersId,$item['id']);
                    }
                    $projects =$this->projectRepository->findBy(['user'=>$arrayUsersId,'project_sector'=>$sector]);*/
   
        /*No USER*/
        else{
                if($lat!= 0 && $long!=0 ){
                    $km = $km!=0 ? $km:10000 ;
                    $usersProjectsByDistance = $this->userRepository->findByDistance($lat,$long,$km);
                    $arrayUsersId =[];
                        foreach($usersProjectsByDistance as $item){
                            array_push($arrayUsersId,$item['id']);
                        }
                    $projects =$this->projectRepository->findBy(['user'=>$arrayUsersId]);
                    
                }
                elseif($sector != 0 && $km != 0){
                    $usersProjectsByDistance = $this->userRepository->findByDistance($lat,$long,$km);
                    $arrayUsersId =[];
                    foreach($usersProjectsByDistance as $item){
                        array_push($arrayUsersId,$item['id']);
                    }
                    $projects =$this->projectRepository->findBy(['user'=>$arrayUsersId,'project_sector'=>$sector]); 
                    dump($sector,$km);                
                }
                elseif($sector!=0 && $km == 0){
                    $projects =$this->projectRepository->findBy(['project_sector'=>$sector]);   
                                   
                }
                else{
                    $projects = $this->projectRepository->findAll() ;
                    
                }
            }
        shuffle($projects);
        return $projects;
    }
}