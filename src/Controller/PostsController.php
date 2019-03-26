<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Form\PostsType;
use App\Entity\Posts;

class PostsController extends AbstractController
{   
    private $session;
    
    public function __construct(){
         $this->session=new Session();
    }
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $post_repo=$em->getRepository("App:Posts");

        $posts=$post_repo->findAll();

        return $this->render('posts/index.html.twig', [
            "posts" => $posts
        ]);


    }
    public function addAction(Request $request)
    {
        $post= new Posts();
        $form = $this->createForm(PostsType::class,$post);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $post_repo=$em->getRepository("App:Posts");
                
                $post= new Posts();
                $post->setDate(new \DateTime());
                $post->setTitle($form->get("title")->getData());
                $post->setContent($form->get("content")->getData());
                $post->setSummary($form->get("summary")->getData());
                //upload file
                $file=$form["image"]->getData();
                if(!empty($file)&& $file!=null){
                    $ext=$file->guessExtension();
                    $file_name=time().".".$ext;
                    $file->move("uploads",$file_name);

                    $post->setImage($file_name);
                }else{
                    $post->setImage(null);
                } 

                $user=$this->getUser();
                $post->setUser($user);


                $em->persist($post);
                $flush = $em->flush();

                if($flush==null){
                    $status="La entrada se ha creado!!!";
                }else{
                    $status="Error al añadir la entrada!!!";
                }              
            }else{
                $status= "La entrada no se ha creado";
            }
            $this->session->getFlashBag()->add("status",$status);
            return $this->redirectToRoute("posts");
        } 
        return $this->render('posts/add.html.twig', [
            "form" => $form->createView()
        ]);
    }
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $post_repo=$em->getRepository("App:Posts");
    
        $post=$post_repo->find($id);
  
        if(is_object($post)){      
            $em->remove($post);
            $em->flush();
        }
        return $this->redirectToRoute("posts");

    }

    public function editAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $post_repo=$em->getRepository("App:Posts");

        $post=$post_repo->find($id);
        $post_image=$post->getImage();

        $form=$this->createForm(PostsType::class,$post);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            if($form->isValid()){
                $post->setTitle($form->get("title")->getData());
                $post->setContent($form->get("content")->getData());
                $post->setSummary($form->get("summary")->getData());
                $post->setDate(new \DateTime());
    
                //upload file
                $file=$form["image"]->getData();

                if(!empty($file)&& $file!=null){

                    $ext=$file->guessExtension();
                    $file_name=time().".".$ext;
                    $file->move("uploads",$file_name);

                    $post->setImage($file_name);
                }else{
                    $post->setImage($post_image);
                }    

                $user=$this->getUser();
                $post->setUser($user);

                $em->persist($post);
                $flush = $em->flush();

                if($flush==null){
                    $status="Se ha editado!!!";
                }else{
                    $status="Error al editar!!!";
                }              
            }else{
                $status= "El formulario no es valido";
             }

            $this->session->getFlashBag()->add("status",$status);
            return $this->redirectToRoute("posts");
        }     
                
        return $this->render('posts/edit.html.twig', [
            "form" => $form->createView(),
            "post" =>$post
        ]);            
    }

    public function detailAction(Request $request,$id) {
        $em = $this->getDoctrine()->getManager();
        $post_repo=$em->getRepository("App:Posts");
    
        $post=$post_repo->find($id);
     

        return $this->render('posts/detail.html.twig', [
            "post" => $post
        ]); 
       

    }
}
