<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Entreprise;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'uk-input'],
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'uk-input'],
            ])
            ->add('date_naissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'uk-input'],
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'uk-input'],
            ])
            ->add('cp', TextType::class, [
                'attr' => ['class' => 'uk-input'],
            ])
            ->add('ville', TextType::class, [
                'attr' => ['class' => 'uk-input'],
            ])
            ->add('date_embauche', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'uk-input'],
            ])
            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'raisonSociale',

                'attr' => ['class' => 'uk-select'],
            ])
            /*
             * upload image
             */
            ->add('image', FileType::class, [
                'data_class' => null,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                    ]),
                ],
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'uk-button uk-button-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
