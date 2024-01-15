<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['placeholder' => 'Nom ','class' => 'form-control validate','minlength' => '3','maxlength' => '50'],
                'label' => 'Nom :',
                'label_attr' => ['class' => 'form-label'],
                // 'constraints' => [
                //     new Assert\Length(['min' => 3, 'max' => 50]),
                // ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['placeholder' => 'prenom','class' => 'form-control validate','minlength' => '3','maxlength' => '50'],
                'label' => 'Prénom :',
                'label_attr' => ['class' => 'form-label'],
                // 'constraints' => [
                //     new Assert\Length(['min' => 3, 'max' => 50]),
                // ]
            ])
            ->add('datnais', DateType::class, [
                'attr' => ['placeholder' => 'prenom','class' => 'form-control validate','minlength' => '3','maxlength' => '50'],
                'required'=> false,
                'label' => 'Date de naissance :',
                'label_attr' => ['class' => 'form-label'],
                'widget' => 'single_text',
            ])
            ->add('ville', TextType::class, [
                'attr' => ['placeholder' => 'Ville','class' => 'form-control validate','minlength' => '3','maxlength' => '50'],
                'required'=> false,
                'label' => 'Ville :',
                'label_attr' => ['class' => 'form-label'],
                // 'constraints' => [
                //     new Assert\Length(['min' => 3, 'max' => 50]),
                // ]
            ])
            ->add('sexe', TextType::class, [
                'attr' => ['placeholder' => 'Sexe ','class' => 'form-control validate','minlength' => '1','maxlength' => '1'],
                'label' => 'Sexe :',
                'label_attr' => ['class' => 'form-label'],
                // 'constraints' => [
                //     new Assert\Length(['min' => 3, 'max' => 50]),
                // ]
            ])
            ->add('bac', FileType::class, [
                'attr'=> ['class' => 'form-control form-control-sm'],
                'mapped' => false,
                'required' => false,
                'label' => 'Diplome de BAC :',
                'constraints' => [
                    new File([
                        // 'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('codopt',EntityType::class, [
                'placeholder' => 'Selectionner la Option',
                'attr'=> ['class' => 'form-control form-control-sm'],
                'class' => Option::class,
                'choice_label' => 'nomopt',
                'required' => true,
                'label' => 'Option :',
                'label_attr' => [
                    'class' => 'form-label',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
