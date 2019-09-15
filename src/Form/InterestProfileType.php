<?php

namespace App\Form;

use App\Entity\InterestProfile;
use App\Repository\ProjectRepository;
use App\Repository\ProfileUserRepository;
use App\Repository\CoworkingRepository;
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
    private $coworkingRepository;
    public function __construct(
          ProjectRepository $projectRepository,
          ProfileUserRepository $profileUserRepository,
          CoworkingRepository $coworkingRepository
      
        ) {
       
        $this->projectRepository = $projectRepository;
        $this->profileUserRepository = $profileUserRepository;
        $this->coworkingRepository = $coworkingRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $projects = $this->projectRepository-> findBy(['user' =>$options['userId']]);
        $profileUser =$this->profileUserRepository->findBy(['user' =>$options['profileUserId']]);
        $coworkingList = $this->coworkingRepository->findAll();
        
        $projectDropDown =[];
        foreach($projects as $project){
            $projectDropDown[$project->getProjectName()]=$project;
        }
        
        $profileDropDown =[];        
        foreach($profileUser as $profile){            
            $profileDropDown[$profile->getProfil()->getName()]= $profile->getProfil();
        } 

        $coworkingDropDown =[];
        foreach($coworkingList as $coworking){            
            $coworkingDropDown[$coworking->getName()]= $coworking->getId();
        } 
        $builder          
            
            ->add('interest_profile',ChoiceType::class,[ 
                'choices' => $profileDropDown,
                'label' => false ,
                ])
            ->add('interest_project',ChoiceType::class,[ 
                    'choices' => $projectDropDown,
                    'label' => false ,
                    ])    
            ->add('interest_description',TextareaType::class,[
                'required'=>false,
                'label'=>false
                ]) 
            ->add('submit', SubmitType::class,['label' => 'Enviar'])
            ->add('extra_profil_deal_add',ChoiceType::class,[ 
                
                'choices' => [  'Tipo de acuerdo'=>'placeholder',
                                '% Empresa'=>'% Empresa',
                                '% Ventas'=>'% Ventas',
                                'Obra y Servicios'=>'Obra y Servicios',
                                'Pacto a Futuro'=>'Pacto a Futuro',
                            ],
                'mapped'=>false, 
                'label' => false ,
                'required'=>false,  
                'placeholder' => false,            
                ])
                          
            ->add('extra_profil_percent_add',NumberType::class,[               
                'required'=>false,
                'label' => false,
                'mapped'=>false
                
                ]) 
            ->add('coworking',ChoiceType::class,[ 
                    'choices' => $coworkingDropDown,
                    'label' => false ,
                    'placeholder' => 'Lista de Coworking', 
                    'required'=>false,  
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
