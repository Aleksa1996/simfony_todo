<?php

namespace App\Form;

use App\Entity\Todo;
use App\Entity\Worker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class, ['label' => 'Opis'])
            ->add('medium', ChoiceType::class, ['label' => 'Medijum', 'choices' => Todo::getMediumMapping()])
            ->add('worker', EntityType::class, ['class' => Worker::class, 'label' => 'Zaposleni', 'choice_label' => function (Worker $worker) {
                return $worker->getFirstname() . ' ' . $worker->getLastname();
            }])
            ->add('contact', EntityType::class, ['class' => Worker::class, 'label' => 'Kontakt', 'choice_label' => 'fullName'])
            ->add('duration', IntegerType::class, ['label' => 'Trajanje (min)'])
            ->add('priority', IntegerType::class, ['label' => 'Prioritet'])
            ->add('date_planed', DateTimeType::class, ['label' => 'Planiran datum'])
            ->add('date_deadline', DateTimeType::class, ['label' => 'Rok zavrsetka'])
            ->add('save', SubmitType::class, ['label' => 'Sacuvaj']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
        ]);
    }
}
