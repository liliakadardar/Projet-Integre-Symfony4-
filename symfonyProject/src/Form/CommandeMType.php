<?php

namespace App\Form;

use App\Entity\CommandeM;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommandeMType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_creation')
            ->add('address_destination')
            ->add('total')
            ->add('quantite')
            ->add('save', SubmitType::class,[
                'attr'=>[ 'class'=>"nicdark_btn_icon nicdark_bg_red  small _circle white"]])
            ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandeM::class,
        ]);
    }
}
