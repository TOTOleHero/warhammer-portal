<?php

namespace App\Form;

use App\Entity\ProfileWFB9;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileWFB9Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('movement')
            ->add('weaponSkill')
            ->add('ballisticSkill')
            ->add('strength')
            ->add('toughness')
            ->add('wounds')
            ->add('initiative')
            ->add('attacks')
            ->add('leadership')
            ->add('gameSystem')
            ->add('unit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfileWFB9::class,
        ]);
    }
}
