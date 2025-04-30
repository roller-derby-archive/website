<?php

namespace App\Form;

use App\Entity\Championship;
use App\Form\Helper\DatePicker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('edition', TextType::class, ['required' => false])
            ->add('description', TextType::class, ['required' => false])
            ->add('championship', EntityType::class, [
                'class' => Championship::class,
                'choice_label' => 'name',
            ]);
        DatePicker::addDatePicker($builder, 'startAt', 'Commence le');
        DatePicker::addDatePicker($builder, 'disbandAt', 'Finis le');
        $builder->add('save', SubmitType::class, ['label' => 'Enregistrer']);
    }
}
