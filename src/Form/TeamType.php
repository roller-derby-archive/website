<?php

namespace App\Form;

use App\Entity\Club;
use App\Enum\County;
use App\Enum\TeamCategory;
use App\Enum\TeamLevel;
use App\Form\Helper\DatePicker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // General information
        $builder
            ->add('name', TextType::class)
            ->add('category', EnumType::class, [
                'class' => TeamCategory::class,
                'choice_value' => function (null|TeamCategory|string $enum): string {
                    if (is_string($enum)) {
                        return TeamCategory::tryFrom($enum) ? $enum : '';
                    }

                    return $enum ? $enum->value : '';
                }
            ])
            ->add('level', EnumType::class, [
                'required' => false,
                'class' => TeamLevel::class,
                'choice_value' => function (null|TeamLevel|string $enum): string {
                    if (is_string($enum)) {
                        return TeamCategory::tryFrom($enum) ? $enum : '';
                    }

                    return $enum ? $enum->value : '';
                }
            ])
            ->add('type', EnumType::class, [
                'class' => \App\Enum\TeamType::class,
                'choice_value' => function (null|\App\Enum\TeamType|string $enum): string {
                    if (is_string($enum)) {
                        return \App\Enum\TeamType::tryFrom($enum) ? $enum : '';
                    }

                    return $enum ? $enum->value : '';
                }
            ])
            ->add('overview', TextareaType::class, ['label' => 'Introduction :', 'required' => false])
        ;
        DatePicker::addDatePicker($builder, 'createdAt', 'Créé le: ');
        // DatePicker::addDatePicker($builder, 'disbandAt', 'Date de dissolution: ');

        // History
        $builder->add('history', TextareaType::class, ['label' => 'Histoire :', 'required' => false]);

        // Clubs
        $builder->add('clubs', EntityType::class, [
            'choice_label' => 'name',
            'attr' => ['class' => 'rda-display-none rda-list-wrapper'],
            'class' => Club::class,
            'multiple' => true,
            'expanded' => true,
            'by_reference' => false,
        ]);

        // Social medias
        $builder
            ->add('flattrackId', IntegerType::class)
            ->add('email', EmailType::class, ['label' => 'Email:', 'required' => false])
            ->add('facebookId', TextType::class, ['label' => 'Facebook:', 'required' => false])
            ->add('instagramId', TextType::class, ['label' => 'Instagram:', 'required' => false])
        ;

        $builder
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }
}
