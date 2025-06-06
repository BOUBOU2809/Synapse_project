<?php

namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class ProcessusTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void{
        $builder
            ->add('Nom_du_processus_evaluation', ChoiceType::class, [
                'attr' => [
                    "placeholder" => "Nommer votre processus",
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'flex-fill'
                ],
                'label' => false,
                'choices' => [
                    'Choisissez votre evaluation'=>'Choisissez votre evaluation',
                    'Evaluation de diagnostic' =>'Evaluation de diagnostic',
                    'Evaluation formative'=> 'Evaluation formative',
                    'Evaluation sommative'=> 'Evaluation sommative',
                    'Evaluation de certification' => 'Evaluation de certification',
                ],
            ])
            ->add('Suivant', SubmitType::class, [
                'attr' => ['class' => 'btn btn-dark'],
                'row_attr' => ['class' => 'px-3'],
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}