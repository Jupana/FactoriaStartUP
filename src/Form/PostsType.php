<?php

namespace App\Form;

use App\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,array(
                "label"=>"Titulo:",
                "attr"=>array("class"=>"form-control")      
            ))
            ->add('summary',TextareaType::class,array(
                "label"=>"Summary:",
              
            ))
            ->add('content',TextareaType::class,array(
                "label"=>"Contenido:",     
  
            ))
            ->add('image',FileType::class,array(
                "label"=>"Imagen",
                "attr"=>array("class"=>"form-control"), 
                "data_class"=>null,
                "required" => false
            ))
            ->add('Guardar', SubmitType::class,array(
                "attr"=>array("class"=>"form-submit buton")
            ))
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
