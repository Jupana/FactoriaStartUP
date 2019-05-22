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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project_name',TextType::class, ['label' => 'Nombre del proyecto *', 'required'=>true])
            ->add('project_sector',EntityType::class,[
                'class' => Sector::class,
                'placeholder' => 'Selecciona un sector',
                'choice_label' => function($sector){
                    return $sector->getName();
                }
            ]) 
            ->add('project_short_description',TextareaType::class , ['label' => 'Definelo en una linea*'])
            ->add('project_description',TextareaType::class,['label' => 'Rezumen ejecutivo*'])
            ->add('project_potentialy_users',TextType::class,['label' => 'Usuarios*'])
            ->add('project_potentialy_companies',TextType::class,['label' => 'Empresas*'])
            ->add('project_aprox_facturation1',NumberType::class,['label' => 'Año 1*'])
            ->add('project_aprox_facturation2',NumberType::class,['label' => 'Año 2*'])
            ->add('project_aprox_facturation3',NumberType::class ,['label' => 'Año 3*'])
            ->add('project_competitors',TextType::class ,['label' => 'Competidores*'])
            ->add('phase_idea',CheckboxType::class )
            ->add('phase_ideaMV',CheckboxType::class )
            ->add('phase_productoMV',CheckboxType::class )
            ->add('phase_productoFinal',CheckboxType::class )
            ->add('project_team',CheckboxType::class )
            ->add('project_team_number',NumberType::class,['label' => 'Nr*'])
           
           
           
           // ->add('submit', SubmitType::class,['label'=>'Guardar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
