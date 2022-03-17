<?php

namespace App\Form;

use App\Entity\CategorieM;
use App\Entity\Materiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('numtel')
            ->add('prix_m')
            ->add('description')
            ->add('nom_materiel')
            ->add('image',FileType::class,
                array('data_class'=>null,'required'=>false))

            ->add('categorie',EntityType::class,[
                'class'=>CategorieM::class,
                'choice_label'=>'nomCatM'
            ])


            ->add('Create', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
