<?php
namespace App\Controller;


use App\Services\GetMatchProjects;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class MatchProjectController extends Controller
{
    
    public function getMatch(GetMatchProjects $getMatchProjects){

        return new JsonResponse($getMatchProjects->getMatch(1,9));
    }
    
}