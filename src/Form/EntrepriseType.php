<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raison_sociale', TextType::class, [
                'attr' => ['class' => 'uk-input'],
            ])
            ->add('siret', TextType::class, [
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
            ->add('date_creation', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'uk-input'],
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'uk-button uk-button-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
