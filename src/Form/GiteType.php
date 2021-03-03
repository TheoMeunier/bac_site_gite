<?php

namespace App\Form;

use App\Entity\Gite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'form.gites.name'
            ])
            ->add('surface', TextType::class, [
                'label' => 'form.gites.surface'
            ])
            ->add('chambres', TextType::class, [
                'label' => 'form.gites.chambre'
            ])
            ->add('personnes', TextType::class, [
                'label' => 'form.gites.personnes'
            ])
            ->add('price', TextType::class, [
                'label' => 'form.gites.price'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'form.gites.description'
            ])
            ->add('image', FileType::class, [
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'label' => 'form.gites.image',
                'attr' => [
                    'placeholder' => 'Choisir un fichier',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gite::class,
            'translation_domain' => 'forms'
        ]);
    }
}
