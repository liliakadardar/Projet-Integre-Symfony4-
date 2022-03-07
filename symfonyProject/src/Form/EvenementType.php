<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_e',TextType::class,[

                'constraints' =>[
                    new NotBlank(),
                ]
            ])
            ->add('date_deb' ,DateType::class, [
        'widget' => 'single_text',
        'constraints'=>[
            new NotBlank()
        ],
        // this is actually the default format for single_text
        'format' => 'yyyy-MM-dd',])

            ->add('date_fin' ,DateType::class, [
                'widget' => 'single_text',
                'constraints'=>[
                    new NotBlank()
                ],
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',])

            ->add('description')
            ->add('prix_e')
            ->add('categoryId',EntityType::class,array(
                'class' => 'App:CategorieE',
                'mapped' => false,
                'constraints'=>[
                    new NotBlank()
                ]
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
