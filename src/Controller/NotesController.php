<?php

namespace App\Controller;

use App\Form\NotesType;
use App\Entity\Notes;
use App\Repository\NotesRepository;
use App\Repository\InterestProfileRepository;
use App\Repository\InterestProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class NotesController extends AbstractController
{
    

    private $notesRepository;

    public function __construct(Notesrepository $notesRepository, 
                                InterestProfileRepository $interestProfileRepository,
                                InterestProjectRepository $interestProjectRepository)
    {
        $this->notesRepository = $notesRepository;
        $this->interestProfileRepository= $interestProfileRepository;
        $this->interestProjectRepository = $interestProjectRepository;
    }
   
    public function listNotes()
    {   
        //Aqui hemos hecho los mismo con los mensajes, he creado una query para sacar todas las notas del usuario y los he agrupado por usuario para que no se 
        $userNotes = $this->notesRepository->findNotes($this->getUser()->getId());
        dump($userNotes);

        return $this->render('notes/list-notes.html.twig', [
            'userNotes' => $userNotes,
            
        ]);
    }
  
    public function note($id,$type_interest,Request $request)
    {   
        $user = $this->getUser();
        $userId =$this->getUser()->getId();
        $userNotes = $this->notesRepository->findNotes($userId);
        $note = $this->notesRepository->findNote($id,$userId);
        dump($userNotes);
        
        //Empesamos a crear aqui la nota y la vamos a rellenar con los campos que necesitamos dependiendo del tipo de interes
        $newNote = new Notes();
        $newNote->setUser($user);
        //Sacamos el tipo de interest y dependiendo del tipo que sea nos vamos al repo y sacamos el dato.
        
        $dataFirstNote =[];

        if( $type_interest == 'interest_profile'){            
            $interestProfile = $this->interestProfileRepository->findOneBy(['id'=>$id]);
            $profileId=$interestProfile->getId();
            $uniqueID = $userId.'-'.$profileId.'-'.rand(1000,10000000);
            
            $newNote->setInterestProfile($interestProfile);
            $newNote->setProjectNotes($interestProfile->getInterestProject());
            $newNote->setNotesUniqId($uniqueID); 
            $dataFirstNote['userContact'] =$interestProfile->getUserProfileOwner()->getName();
            $dataFirstNote['project'] =$interestProfile->getInterestProject()->getProjectName();
            $dataFirstNote['profile'] =$interestProfile->getInterestProfile()->getName();
                     
        }
        if($type_interest == 'interest_project'){            
            $interestProject = $this->interestProjectRepository->findOneBy(['id'=>$id]);       
            $projectId=$interestProject->getId();
            $uniqueID = $userId.'-'.$projectId.'-'.rand(1000,10000000);

            $newNote->setInterestProject($interestProject);
            $newNote->setProfileNotes($interestProject->getInterestProfil());
            $newNote->setNotesUniqId($uniqueID); 
       
            $dataFirstNote['project'] =$interestProject->getInterestIdProject()->getProjectName();
            $dataFirstNote['profile'] =$interestProject->getInterestProfil()->getName();           
        }

        if(!empty($note)){
            $newNote->setInterestProfile($note[0]->getInterestProfile());
            $newNote->setInterestProject($note[0]->getInterestProject());
            $newNote->setNotesUniqId($note[0]->getNotesUniqId());
        }
        

        $form = $this->createForm(
            NotesType::class,
            $newNote
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {        
            $newNote->setNotesDate(new \DateTime());
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newNote);
            $entityManager->flush();

            return $this->redirectToRoute('note',['id'=>$id,'type_interest'=>$type_interest]);
        }


        return $this->render('notes/note.html.twig', [
            'note' => $note,
            'userNotes'=>$userNotes,
            'form' => $form->createView(),
            'dataFirstNote'=>$dataFirstNote
        ]);
    }
}
