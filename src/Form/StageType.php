<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Form\EntrepriseType;

use App\Repository\FormationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Entreprise;
use App\Entity\Formation;
class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('titre')
            ->add('domaine')
            ->add('description')
            ->add('email')
            ->add('entreprise',EntrepriseType::class)
            //->add('formation')
            ->add('formation',EntityType::class, [
                'class' => Formation::class,
                'choice_label' => function(Formation $formations)
                                    {return $formations->getNomLong();},
                'multiple' => true,
                'expanded' => true
                ])
            ->add('enregistrer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
