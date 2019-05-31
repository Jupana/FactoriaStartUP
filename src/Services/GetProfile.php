<?php

namespace App\Services;

use App\Repository\UserRepository;
use App\Repository\ProfileUserRepository;
use App\Entity\User;

class GetProfile{

   
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
                    $profiles =$this->profilRepository->findBy(['user'=>$arrayUsersId],['user'=>'ASC']);
                    
                }
                elseif($profile != 0 && $km != 0){
                    $usersProjectsByDistance = $this->userRepository->findByDistance($user->getLatitud(),$user->getLongitud(),$km);
                    $arrayUsersId =[];
                    foreach($usersProjectsByDistance as $item){
                        array_push($arrayUsersId,$item['id']);
                    }
                    $profiles =$this->profilRepository->findBy(['user'=>$arrayUsersId,'profil'=>$profile],['user'=>'ASC']); 
                                
                }
                elseif($profile != 0 && $km == 0){
                    $profiles =$this->profilRepository->findBy(['profil'=>$profile],['user'=>'ASC']);                 
                }
                else{                                 
                    $profiles = $this->profilRepository->findBy([],['user'=>'ASC']);
                    
                }
            }        
            else{
                if($profile != 0 && $km != 0){
                    $usersProjectsByDistance = $this->userRepository->findByDistance($lat,$long,$km);
                    $arrayUsersId =[];
                    foreach($usersProjectsByDistance as $item){
                        array_push($arrayUsersId,$item['id']);
                    }
                    $profiles =$this->profilRepository->findBy(['user'=>$arrayUsersId,'profil'=>$profile],['user'=>'ASC']); 
                    
                }elseif($profile == 0 && $km != 0){
                    $usersProjectsByDistance = $this->userRepository->findByDistance($lat,$long,$km);
                    $arrayUsersId =[];
                    foreach($usersProjectsByDistance as $item){
                        array_push($arrayUsersId,$item['id']);
                    }
                    $profiles =$this->profilRepository->findBy(['user'=>$arrayUsersId],['user'=>'ASC']); 
                    
                }
                elseif($profile!=0 && $km == 0){
                    $profiles =$this->profilRepository->findBy(['profil'=>$profile],['user'=>'ASC']);                                  
                }
                else{
                    $profiles = $this->profilRepository->findBy([],['user'=>'ASC']);                
                }
            }

            $prepareProfiles = [];
            $i=0;
            foreach($profiles as $item){
                               
                $user = $item->getUser()->getId();
                
                if(isset($lastUser) && ($lastUser != $user)){                    
                    $i=0;
                }
                
                $prepareProfiles[$user]['user_id'] =$user;
                $prepareProfiles[$user]['name'] =$item->getUser()->getUsername();
                $prepareProfiles[$user]['user_img'] =$item->getUser()->getPerfilImg();
                $prepareProfiles[$user]['perfiles'][$i] =$item->getProfil();
                $prepareProfiles[$user]['sectors'][$i] =$item->getSector();
                
                $lastUser = $user;

                $i++;
            }

        return $prepareProfiles;
    }
}
