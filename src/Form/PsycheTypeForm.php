<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PsycheTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('beginningDate', DateType::class, [
                'label' => 'Date de Début',
                'required' => true,
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'row_attr' => ['class' => 'py-3 col'],
                ])
            ->add('endingDate', DateType::class, [
                'label' => 'Date de Fin',
                'required' => true,
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'row_attr' => ['class' => 'py-3 col'],
                ])
            ->add('Search', SubmitType::class, [
                'attr' => ['class' => 'btn btn-dark my-3'],
                'row_attr' => ['class' => 'col d-flex flex-row-reverse align-items-end'],
                'label'=> 'Rechercher',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'constraints' => [
                new NotBlank(),
            ]
        ]);
    }
}
