<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Sector;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project_name',TextType::class, ['label' => 'Nombre del proyecto *', 'required'=>true])
            ->add('project_short_description',TextareaType::class , ['label' => 'Definelo en una linea*','required'=>true])
            ->add('project_description',TextareaType::class,['label' => 'Rezumen ejecutivo*','required'=>true])
            ->add('project_potentialy_users',TextType::class,['label' => 'Usuarios*','required'=>true])
            ->add('project_potentialy_companies',TextType::class,['label' => 'Empresas*','required'=>true])
            ->add('project_aprox_facturation1',NumberType::class,['label' => 'Año 1*','required'=>true])
            ->add('project_aprox_facturation2',NumberType::class,['label' => 'Año 2*','required'=>true])
            ->add('project_aprox_facturation3',NumberType::class ,['label' => 'Año 3*','required'=>true])
            ->add('project_competitors',TextType::class ,['label' => 'Competidores*','required'=>true])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
