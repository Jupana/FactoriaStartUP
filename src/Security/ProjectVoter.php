<?php
namespace App\Security;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;


class ProjectVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE ='delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])){
            return  false;
        }
        if (!$subject instanceof Project){
            return false;
        }
        return true;
    }
    protected function voteOnAttribute(
        $attribute, $subject, TokenInterface $token
    ){
        $authenticatedUser = $token->getUser();

        if (!$authenticatedUser instanceof User){
            return false;
        }

        /** @var Project $project */
        $project = $subject;
        
        return ($project->getUser()->getId() === $authenticatedUser->getId());
    
    }
}