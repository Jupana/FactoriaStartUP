<?php

namespace App\Services;

use App\Repository\UserRepository;
use App\Repository\ProfileUserRepository;


class GetProfile{

    /**
     * 
     * var @ProjectRepository
     * */ 
    private $profilRepository;
    
    private $userRepository;
    

    public function __construct(ProfileUserRepository $profilRepository, UserRepository $userRepository)
    {    
        $this->profilRepository = $profilRepository;
        $this->userRepository =$userRepository;
    }

    public function listProfile($user,$profile=null,$km = null, $lat=0, $long=0){
        
        if($user){
                if($profile == 0 && $km != 0){
                    $usersProjectsByDistance = $this->userRepository->findByDistance($user->getLatitud(),$user->getLongitud(),$km);
                    $arrayUsersId =[];
                    foreach($usersProjectsByDistance as $item){
                        array_push($arrayUsersId,$item['id']);
                    }
                    $profiles =$this->profilRepository->findBy(['user'=>$arrayUsersId]);
                    
                }
                elseif($profile != 0 && $km != 0){
                    $usersProjectsByDistance = $this->userRepository->findByDistance($user->getLatitud(),$user->getLongitud(),$km);
                    $arrayUsersId =[];
                    foreach($usersProjectsByDistance as $item){
                        array_push($arrayUsersId,$item['id']);
                    }
                    $profiles =$this->profilRepository->findBy(['user'=>$arrayUsersId,'profil'=>$profile]); 
                    dump($usersProjectsByDistance);              
                }
                elseif($profile != 0 && $km == 0){
                    $profiles =$this->profilRepository->findBy(['profil'=>$profile]);                 
                }
                else{                                 
                    $profiles = $this->profilRepository->findAll() ;
                }
            }        
            else{
                if($profile != 0 && $km != 0){
                    $usersProjectsByDistance = $this->userRepository->findByDistance($lat,$long,$km);
                    $arrayUsersId =[];
                    foreach($usersProjectsByDistance as $item){
                        array_push($arrayUsersId,$item['id']);
                    }
                    $profiles =$this->profilRepository->findBy(['user'=>$arrayUsersId,'profil'=>$profile]); 
                    dump($profile,$km);                
                }elseif($profile == 0 && $km != 0){
                    $usersProjectsByDistance = $this->userRepository->findByDistance($lat,$long,$km);
                    $arrayUsersId =[];
                    foreach($usersProjectsByDistance as $item){
                        array_push($arrayUsersId,$item['id']);
                    }
                    $profiles =$this->profilRepository->findBy(['user'=>$arrayUsersId]); 
                    dump($profile,$km);                
                }
                elseif($profile!=0 && $km == 0){
                    $profiles =$this->profilRepository->findBy(['profil'=>$profile]);   
                                
                }
                else{
                    $profiles = $this->profilRepository->findAll();                
                }
            }
        return $profiles;
    }
}