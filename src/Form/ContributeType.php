<?php

namespace App\Form;

use App\Entity\Contribute;
use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contribute_profile',EntityType::class,[
                'class' => Profil::class,
                
                'placeholder' => 'Selecciona un perfil',                
                'choice_label' => function($profil){
                        return $profil->getName(); 
                    },
                'required'=>false,
                
            ])    
            ->add('contribute_description',TextareaType::class,['label' => 'Pequeña Descripcion:','required'=>false])  
           ->add('submit', SubmitType::class,['label'=>'Guardar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contribute::class,
        ]);
    }
}
