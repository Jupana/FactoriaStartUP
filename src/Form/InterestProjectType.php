<?php

namespace App\Form;

use App\Entity\Profil;
use App\Entity\Sector;
use App\Entity\InterestProject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class InterestProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('interest_sector',EntityType::class,[
                'class' => Sector::class,
                'placeholder' => 'Selecciona un sector',
                'choice_label' => function($sector){
                    return $sector->getName();
                }
            ])
            ->add('interest_profil',EntityType::class,[
                'class' => Profil::class,                
                'placeholder' => 'Selecciona un perfil',                
                'choice_label' => function($profil){
                        return $profil->getName(); 
                    },
                'required'=>false
            ])
            ->add('interest_deal',ChoiceType::class,[ 
                'choices' => [
                                'Tipo de acuerdo'=>'Tipo de acuerdo',
                                '% Empresa'=>'% Empresa',
                                '% Ventas'=>'% Ventas',
                                'Obra y Servicios'=>'Obra y Servicios',
                                'Pacto a Futuro'=>'Pacto a Futuro',
                            ], 
                ])
            ->add('interest_percent',NumberType::class,['required'=>false])
            ->add('interest_description',TextareaType::class,['required'=>false])
            ->add('submit', SubmitType::class,['label' => 'Enviar']) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InterestProject::class,
        ]);
    }
}
