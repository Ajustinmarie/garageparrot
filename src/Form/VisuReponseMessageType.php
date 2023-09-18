<?php

namespace App\Form;

use App\Entity\MessageContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VisuReponseMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nom', TextType::class,[
                'disabled'=>true
            ])
            
            ->add('prenom', TextType::class,[
                'disabled'=>true
            ])

            ->add('sujet', TextType::class,[
                'disabled'=>true
            ])

            ->add('sujet', TextType::class,[
                'disabled'=>true
            ])

            ->add('numero', TextType::class,[
                'disabled'=>true
            ])

            ->add('message', TextareaType::class,[
                'disabled'=>true
            ])

            ->add('email', EmailType::class,[
                'disabled'=>true
            ])
 
          //  ->add('status')
          //  ->add('idReponseContact')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MessageContact::class,
        ]);
    }
}
