<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'form.contact.firstname'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'form.contact.lastname'
            ])
            ->add('phone', TextType::class, [
                'label' => 'form.contact.phone'
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.contact.email'
            ])
            ->add('message', TextareaType::class, [
                'label' => 'form.contact.message'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'translation_domain' => 'forms'
        ]);
    }
}
