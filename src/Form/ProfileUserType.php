<?php

namespace App\Form;

use App\Entity\ProfileUser;
use App\Entity\Sector;
use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProfileUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('sector',EntityType::class,[
                'class' => Sector::class,
                'placeholder' => 'Selecciona un sector',
                'choice_label' => function($sector){
                    return $sector->getName();
                }
            ]) 
            ->add('profil',EntityType::class,[
                'class' => Profil::class,
                'placeholder' => 'Selecciona un Profile',
                'choice_label' => function($profil){
                    return $profil->getName(); 
                }
            ])    
            ->add('description',TextareaType::class)  
            ->add('submit', SubmitType::class,['label' => 'Guardar Profile'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfileUser::class,
        ]);
    }
}
