<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Sector;
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
            ->add('project_name',TextType::class, ['label' => 'Titulo Proyecto'])
            ->add('project_short_description',TextareaType::class)
            ->add('project_description',TextareaType::class)
            ->add('project_clientes_users',TextType::class)
            ->add('project_potentialy_users',TextType::class)
            ->add('project_potentialy_companies',TextType::class)
            ->add('project_aprox_facturation1',NumberType::class)
            ->add('project_aprox_facturation2',NumberType::class)
            ->add('project_aprox_facturation3',NumberType::class)
            ->add('project_competitors',TextType::class)
            ->add('Guardar',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
