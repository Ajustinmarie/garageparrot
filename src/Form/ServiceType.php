<?php

namespace App\Form;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\SlugType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             
        ->add('name')

        ->add('explication')

        ->add('slug')
    

            ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => true, // Si l'image n'est pas requise
                'attr' => [
                    'accept' => 'image/*', // Limite les types de fichiers acceptés à des images
                ],
                // Ajoutez d'autres contraintes de validation si nécessaire
            ])

            ->add('submit', SubmitType::class,[
                'label'=>"Soumettre"
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
