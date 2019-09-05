<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\Profil;
use App\Entity\Project;
use App\Entity\User;
use App\Entity\InterestProfile;
use App\Entity\InterestProject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('conversation_id',TextType::class)
            ->add('type',TextType::class)
            ->add('text',TextareaType::class,['label' => 'Envia un mensaje...'])
            ->add('time', DateType::class)
            ->add('user_sender',EntityType::class,[
                'class' => User::class,                      
                'choice_label' => function($user){
                        return $user->getId(); 
                    }])
            ->add('user_recipient',EntityType::class,[
                'class' => User::class,                      
                'choice_label' => function($user){
                        return $user->getId(); 
                    }])
            ->add('interest_profil',EntityType::class,[
                'class' => InterestProfile::class,                      
                'choice_label' => function($InterestProfile){
                        return $InterestProfile->getId(); 
                    },
                'required'=>false ])
            ->add('interest_project',EntityType::class,[
                'class' => InterestProject::class,                      
                'choice_label' => function($InterestProject){
                        return $InterestProject->getId(); 
                    },
                'required'=>false ])
            ->add('enviar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
