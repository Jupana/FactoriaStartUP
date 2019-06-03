<?php

namespace App\Form;

use App\Entity\InterestProfile;
use App\Entity\Profil;
use App\Repository\ProjectRepository;
use App\Repository\ProfileUserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
            $profileDropDown[$profile->getProfil()]=$profile->getId();
        } 


        $builder
           
            ->add('interest_project',ChoiceType::class,[ 
            'choices' => $projectDropDown,
            'label'=>'Selecciona un proyecto'
            ])
            ->add('interest_profile',ChoiceType::class,[ 
                'choices' => $profileDropDown,
                'label'=>'Selecciona el perfil que te interesa'
                ])

            ->add('interest_description',TextareaType::class,[
                'required'=>false,
                'label'=>'Escribe tu propuesta'
                ]) 
            ->add('submit', SubmitType::class,['label' => 'Enviar']) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InterestProfile::class,
        ]);
        $resolver->setRequired(array(
            'userId',
            'profileUserId'
        ));

    }
}
