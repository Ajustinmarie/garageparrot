<?php

namespace App\Form;

use App\Entity\Temoignages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Range;

class TemoignagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('commentaire')
             ->add('note', null, [
               'label' => 'Note/20',
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'max' => 20,
                        'minMessage' => 'La note doit être d\'au moins 1.',
                        'maxMessage' => 'La note ne peut pas dépasser 20.',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class,[
                'label'=>"Soumettre"
             ])
           // ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Temoignages::class,
        ]);
    }
}
