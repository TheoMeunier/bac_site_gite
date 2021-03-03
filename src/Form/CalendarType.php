<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\Gite;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'form.calendar.title'
            ])
            ->add('start', DateTimeType::class, [
                'date_widget' => 'single_text',
                'label' => 'form.calendar.start'
            ])
            ->add('end', DateTimeType::class, [
                'date_widget' => 'single_text',
                'label' => 'form.calendar.end'
            ])
            ->add('user', EntityType::class,[
                'required' => false,
                'class' => User::class,
                'choice_label' => 'email',
                'multiple' => false
            ])
            ->add('gite', EntityType::class,[
                'required' => false,
                'class' => Gite::class,
                'choice_label' => 'name',
                'multiple' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => 'form.calendar.description'
            ])
            ->add('all_day')
            ->add('background_color', ColorType::class,[
                'label' => 'form.calendar.background_color'
            ])
            ->add('border_color', ColorType::class,[
                'label' => 'form.calendar.border_color'
            ])
            ->add('text_color', ColorType::class,[
                'label' => 'form.calendar.text_color'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
            'translation_domain' => 'forms'
        ]);
    }
}
