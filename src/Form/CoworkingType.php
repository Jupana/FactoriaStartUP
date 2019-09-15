<?php

namespace App\Form;

use App\Entity\Coworking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class CoworkingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,['label' => false])
            ->add('address',TextType::class,['label' => false])
            ->add('phone',NumberType::class,['label' => false])
            ->add('description',TextareaType::class,['label' => false])
            ->add('img',FileType::class, 
            [
                'label' => false,
                'data_class'=>null,
                'required' => false ,
               
            ])
            ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Coworking::class,
        ]);
    }
}
