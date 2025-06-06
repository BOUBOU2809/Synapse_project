<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class IterationTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Selection_iteration', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'choices' => [
                    '3 fois -- année'=>'3 fois dans l\' année',
                    '5 fois -- année'=>'5 fois dans l\' année',
                    '8 fois -- année'=>'8 fois dans l\' année',
                ]
            ])
            -> add('libelle', TextType::class, [
                'label'=>'Libellé',
                'required' => true,
            ])
            -> add('Date_de_debut', DateType::class, [
                'label'=>'Date de début',
                'required' => true,
            ])
            -> add('Date_de_fin', DateType::class, [
                'label'=>'Date de fin',
                'required' => true,
            ])
            -> add('Date_de_commission', DateType::class, [
                'attr' => [
                    'class'=>'form-control',
                    'data-action'=> 'click->input#input_disabled',
                    'data-search-target'=> 'input_selected'
                ],
                'row_attr'=> [
                    'class'=>'mb-3',
                ],
                'label'=>'Date de commission',
                'required' => true,
            ])
            ->add('Enregister', SubmitType::class, [
                'attr' => ['class' => 'btn btn-dark my-3'],
                'row_attr' => ['class' => 'col d-flex flex-row-reverse align-items-end'],
            ]);

    }
}