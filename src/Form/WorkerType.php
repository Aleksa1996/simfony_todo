<?php

namespace App\Form;

use App\Entity\Position;
use App\Entity\Worker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, ['label' => 'Ime'])
            ->add('lastname', TextType::class, ['label' => 'Prezime'])
            ->add('positions', EntityType::class, ['class' => Position::class, 'label' => 'Pozicija', 'choice_label' => 'name', 'multiple' => true])
            ->add('save', SubmitType::class, ['label' => 'Sacuvaj']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Worker::class,
        ]);
    }
}
