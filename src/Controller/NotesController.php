<?php

namespace App\Controller;

use App\Form\NotesType;
use App\Repository\NotesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class NotesController extends AbstractController
{
    

    private $notesRepository;

    public function __construct(Notesrepository $notesRepository)
    {
        $this->notesRepository = $notesRepository;
    }
   
    public function listNotes()
    {   
        $userNotes = $this->notesRepository->findBy(['user' => $this->getUser()]);
        
        return $this->render('notes/list-notes.html.twig', [
            'userNotes' => $userNotes,
        ]);
    }
  
    public function note($id)
    {   
        $userNotes = $this->notesRepository->findBy(['user' => $this->getUser()]);
        $note = $this->notesRepository->findNote($id);
        return $this->render('notes/note.html.twig', [
            'note' => $note,
            'userNotes'=>$userNotes
        ]);
    }
}
