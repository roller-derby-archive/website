<?php

namespace App\Form;

use App\Entity\Club;
use App\Enum\TeamCategory;
use App\Enum\TeamLevel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('flattrackId', IntegerType::class)
            ->add('category', EnumType::class, [
                'class' => TeamCategory::class,
                'choice_value' => function (?TeamCategory $enum): string {
                    return $enum ? $enum->value : '';
                }
            ])
            ->add('type', EnumType::class, [
                'class' => \App\Enum\TeamType::class,
                'choice_value' => function (?\App\Enum\TeamType $enum): string {
                    return $enum ? $enum->value : '';
                }
            ])
            ->add('level', EnumType::class, [
                'required' => false,
                'class' => TeamLevel::class,
                'choice_value' => function (?TeamLevel $enum): string {
                    return $enum ? $enum->value : '';
                }
            ])
            ->add('clubs', EntityType::class, [
                'class' => Club::class,
                'multiple' => true,
                'choice_label' => 'name',
            ])
            ->add('pronoun', TextType::class, ['required' => false])
            ->add('createdAt', DateType::class, [
                'label' => 'Créé le',
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'format' => 'd/m/Y',
            ])
//            ->add('disbandAt', DateType::class, [
//                'label' => 'Date de dissolution',
//                'input' => 'datetime_immutable',
//                'widget' => 'single_text',
//                'html5' => false,
//                'attr' => ['class' => 'js-datepicker'],
//                'required' => false,
//            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }
}
