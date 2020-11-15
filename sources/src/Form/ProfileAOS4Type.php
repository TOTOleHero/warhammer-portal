<?php

namespace App\Form;

use App\Entity\ProfileAOS4;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileAOS4Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('movement')
            ->add('wounds')
            ->add('bravery')
            ->add('save')
            ->add('gameSystem')
            ->add('unit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfileAOS4::class,
        ]);
    }
}
