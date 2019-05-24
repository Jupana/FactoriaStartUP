<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\Profil;
use App\Repository\UserRepository;
use App\Repository\ProfileUserRepository;
use Symfony\Component\HttpFoundation\Request;

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

    public function listProfile($user,$profile=null,$sector =null,$km = null, $lat=0, $long=0){
        
        if($user){
                if($lat== 0 && $long==0 && $profile == null && $sector ==null){
                    $profiles = $this->profilRepository->findAll() ;
                }else{
                    $usersProfilesByDistance = $this->userRepository->findByDistance($user->getLatitud(),$user->getLongitud(),$km);
                    $arrayUsersId =[];
                    foreach($usersProfilesByDistance as $item){
                        array_push($arrayUsersId,$item['id']);
                    }
                    $profiles =$this->profilRepository->findBy(['user'=>$arrayUsersId,'profil'=>$profile]);
                    //shuffle($profiles);
                }
            }        
        else{
                if($lat!= 0 && $long!=0){
                    $usersProfilesByDistance = $this->userRepository->findByDistance($lat,$long,$km);
                $arrayUsersId =[];
                foreach($usersProfilesByDistance as $item){
                    array_push($arrayUsersId,$item['id']);
                }
                $profiles =$this->profilRepository->findBy(['user'=>$arrayUsersId,'profil'=>$profile]);
                //shuffle($profiles);
                }elseif($profile){
                    $profiles =$this->profilRepository->findBy(['profil'=>$profile]);
                    shuffle($profiles);  
                }
                else{
                    $profiles = $this->profilRepository->findAll() ;
                    //shuffle($Profiles);
                }
            }
        return $profiles;
    }
}