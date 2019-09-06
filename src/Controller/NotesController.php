<?php

namespace App\Controller;

use App\Form\NotesType;
use App\Entity\Notes;
use App\Entity\User;
use App\Repository\NotesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


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
        $note = $this->notesRepository->findAll();
        
        return $this->render('notes/list-notes.html.twig', [
            'userNotes' => $userNotes,
            'note' => $note
        ]);
    }
  
    public function note($id,Request $request)
    {   
        $userNotes = $this->notesRepository->findBy(['user' => $this->getUser()]);
        $note = $this->notesRepository->findNote($id);

        $user = $this->getUser();

        $newNote = new Notes();
        $newNote->setUser($user);
        $newNote->setInterestProfile($note[0]->getInterestProfile());
        $newNote->setInterestProject($note[0]->getInterestProject());

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

            return $this->redirectToRoute('list-notes');
        }


        return $this->render('notes/note.html.twig', [
            'note' => $note,
            'userNotes'=>$userNotes,
            'form' => $form->createView()
        ]);
    }
}
