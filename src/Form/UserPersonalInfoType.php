<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserPersonalInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,
                    [
                        'label' =>false
                    ]
                )
            ->add('name',TextType::class, 
                    [
                        'label' =>false, 
                        'required'=>true
                    ]
                )
            ->add('surname_1',TextType::class, 
                    [
                        'label' =>false,
                        'required'=>true
                    ]
                )
            ->add('surname_2',TextType::class, 
                    [
                        'label' =>false,
                        'required'=>true
                    ]
                    )
            ->add('birth_date',DateType::class, 
                    [
                        'label' =>false,
                        'widget' => 'choice',
                    ]
                )
            ->add('email', EmailType::class,
                    [
                        'label' => false
                    ]
                )
            ->add('phone_number',TelType::class, 
                    [
                        'label' => false
                    ]
                )

            /*->add('sex' ,ChoiceType::class, array(
                'choices' => array('Mujer' => 'm', 'Hombre' => 'h'),
                'choices_as_values' => true,
                'expanded' => true))
            ->add('street_type',ChoiceType::class, array(
                'choices' => array('Avenida' =>'avenida','Calle' => 'calle', 'Via' => 'via'),
                'choices_as_values' => true,
                'expanded' => true))*/
            ->add('street_name',TextType::class, 
                    [
                        'label' => false
                    ]
                )
            ->add('street_number',TextType::class, 
                    [
                        'label' => false
                    ]
                )
            ->add('block',TextType::class, 
                    [
                        'label' => false
                    ]
                )
            ->add('apartment',TextType::class, 
                    [
                        'label' => false
                    ]
                )
            ->add('city',TextType::class, 
                    [
                        'label' => false
                    ]
                )
            ->add('postal_code',NumberType::class, 
                    [
                        'label' => false
                    ]
                )
            ->add('province',TextType::class, 
                    [
                        'label' => false
                    ]
                )
            ->add('country',TextType::class, 
                    [
                        'label' => false
                    ]
                )
            ->add('perfil_img',TextType::class, 
                    [
                        'label' => false
                    ]
                )
            //->add('team_search')  Liviu estos tiene que ponerlos en otro form
            //->add('proyect_search')
           // ->add('phone_number',NumberType::class, ['label' => 'Telefono'])
           // ->add('inscription_date',)  LIVIU estos no tiene que verse pero si que tiene que meterlos.
           // ->add('latitud')
           // ->add('longitud')
           // ->add('IP')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
