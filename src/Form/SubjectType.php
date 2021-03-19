<?php

namespace App\Form;

use App\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // #1. J'ai créé mon formulaire via : php bin/console make:form
        // nom : SubjectType (<= doit toujours se terminer par Type)
        // Lié à l'entité : Subject
        $builder
            ->add('description')
            ->add('createdAt', DateType::class,
                ['label' => 'Date création']
            )
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
        ]);
    }
}
