<?php

namespace App\Form;

use App\Entity\NeedsProject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NeedsProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('needs_id')
            ->add('needs_deal')
            ->add('needs_percent')
            ->add('needs_description')
            ->add('needs_status')
            ->add('needs_date')
            ->add('needs_perfil')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NeedsProject::class,
        ]);
    }
}
