<?php

namespace App\Form;

use App\Entity\ProfesionalProfile;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProfesionalProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profesionalDescription',TextType::class,
                    [
                        'label' =>false
                    ]
                )
            ->add('profesionalSearchProject', CheckboxType::class, 
                    [
                        'required' => false,
                        'value' => 0,
                    ]    
                )
            ->add('profesionalIdUser',EntityType::class,
                    [
                        'class' => User::class,
                        'choice_label' => function ($user) {
                            return $user->getId();
                        }
                    ]
                )    
            //->add('profesionalDate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfesionalProfile::class,
        ]);
    }
}
