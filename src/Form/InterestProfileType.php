<?php

namespace App\Form;

use App\Entity\InterestProfile;
use App\Repository\ProjectRepository;
use App\Repository\ProfileUserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class InterestProfileType extends AbstractType
{

    
    private $projectRepository;
    private $profileUserRepository;
    public function __construct(
          ProjectRepository $projectRepository,
          ProfileUserRepository $profileUserRepository
      
        ) {
       
        $this->projectRepository = $projectRepository;
        $this->profileUserRepository = $profileUserRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $projects = $this->projectRepository-> findBy(['user' =>$options['userId']]);
        $profileUser =$this->profileUserRepository->findBy(['user' =>$options['profileUserId']]);
        
        $projectDropDown =[];
        foreach($projects as $project){
            $projectDropDown[$project->getProjectName()]=$project->getId();
        }
        
        $profileDropDown =[];
        foreach($profileUser as $profile){
            $profileDropDown[$profile->getProfil()]=$profile->getProfil();
        } 

        $builder
           
            ->add('interest_project',ChoiceType::class,[ 
            'choices' => $projectDropDown,
            'label' => false ,
            ])
            ->add('interest_profile',ChoiceType::class,[ 
                'choices' => $profileDropDown,
                'label' => false ,
                ])

            ->add('interest_description',TextareaType::class,[
                'required'=>false,
                'label'=>false
                ]) 
            ->add('submit', SubmitType::class,['label' => 'Enviar'])
            ->add('extra_profil_deal_add',ChoiceType::class,[ 
                'choices' => [  'Tipo de acuerdo'=>'Tipo de acuerdo',
                                '% Empresa'=>'% Empresa',
                                '% Ventas'=>'% Ventas',
                                'Obra y Servicios'=>'Obra y Servicios',
                                'Pacto a Futuro'=>'Pacto a Futuro'
                            ],
                'mapped'=>false, 
                'label' => false ,
                'required'=>false,
                ])
            ->add('extra_profil_percent_add',NumberType::class,[               
                'required'=>false,
                'label' => false,
                'mapped'=>false
                
                ])     
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InterestProfile::class,
            'allow_extra_fields' => true
        ]);
        $resolver->setRequired(array(
            'userId',
            'profileUserId'
        ));

    }
}
