<?php

namespace App\Form;

use App\Entity\Echange;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EchangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'En cours de livraison' => 'En cours de livraison',
                    'livré' => 'livré',
                    'Annulé' => 'Annulé',
                ],
                'attr' => [
                    'class' => 'form-select form-select-lg mb-3',
                    'style' => 'max-width: 400px;'
                ]
            ])
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Echange::class,
        ]);
    }
}
