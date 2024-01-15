<?php

namespace App\Form;

use App\Entity\Option;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RechdecType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('opt',EntityType::class, [
            'mapped' => false,
            'placeholder' => 'Selectionner la Option',
            'attr'=> ['class' => 'form-control form-control-sm'],
            'class' => Option::class,
            'choice_label' => 'nomopt',
            'required' => true,
            'label' => 'Dans l\'option :',
            'label_attr' => ['class' => 'form-label',],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
