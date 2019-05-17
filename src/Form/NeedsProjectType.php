<?php

namespace App\Form;

use App\Entity\NeedsProject;
use App\Entity\Profil;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NeedsProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            //->add('needs_deal')
            ->add('needs_percent',ChoiceType::class,[ 
                'choices' => [
                                '% empresa'=>'% empresa',
                                '% Ventas'=>'% Ventas',
                                'Obra y Servicios'=>'Obra y Servicios',
                                'Pacto a Futuro'=>'Pacto a Futuro',
                            ],
                /*'choice_label' => function ($choice, $key, $value) {
                        if (true === $choice) {
                            return '% empresa';
              
                        return $key;
                
    
                    }},*/
                   // 'choice_label' => 'displayName',   
                ])
            ->add('needs_description',TextareaType::class,['required'=>false])
            ->add('needs_perfil',EntityType::class,[
                'class' => Profil::class,                
                'placeholder' => 'Selecciona un perfil',                
                'choice_label' => function($profil){
                        return $profil->getName(); 
                    },
                'required'=>false
            ])    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NeedsProject::class,
        ]);
    }
}
