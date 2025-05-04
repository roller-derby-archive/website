<?php

namespace App\Form;

use App\Entity\Team;
use App\Enum\ClubGenderDiversityPolicy;
use App\Enum\Country;
use App\Enum\County;
use App\Enum\Region;
use App\Form\Helper\DatePicker;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class ClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // General information
        $builder
            ->add('name', TextType::class, ['label' => 'Nom :'])
            ->add('alias', TextType::class, ['label' => 'Alias :', 'required' => false])
            ->add('cities', CollectionType::class, [
                'label' => 'Villes :',
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('genderDiversityPolicy', EnumType::class, [
                'label' => 'Politique de genre :',
                'class' => ClubGenderDiversityPolicy::class,
                'required' => false,
                'choice_value' => function (null|ClubGenderDiversityPolicy|string $enum): string {
                    if (is_string($enum)) {
                        return ClubGenderDiversityPolicy::tryFrom($enum) ? $enum : '';
                    }

                    return $enum ? $enum->value : '';
                },
                'choice_label' => function (null|ClubGenderDiversityPolicy|string $enum): string {
                    if (is_string($enum)) {
                        $e = ClubGenderDiversityPolicy::tryFrom($enum);
                        return $e ? ClubGenderDiversityPolicy::getName($e->value) : '';
                    }

                    return $enum ? ClubGenderDiversityPolicy::getName($enum->value) : '';
                }
            ])
            ->add('regionCode', EnumType::class, [
                'label' => 'Region :',
                'class' => Region::class,
                'choice_value' => function (null|Region|string $enum): string {
                    if (is_string($enum)) {
                        return Region::tryFrom($enum) ? $enum : '';
                    }

                    return $enum ? $enum->value : '';
                },
                'choice_label' => function (null|Region|string $enum): string {
                    if (is_string($enum)) {
                        $e = Region::tryFrom($enum);
                        return $e ? Region::getName($e->value) : '';
                    }

                    return $enum ? Region::getName($enum->value) : '';
                }
            ])
            ->add('countyCode', EnumType::class, [
                'label' => 'Département :',
                'class' => County::class,
                'choice_value' => function (null|County|string $enum): string {
                    if (is_string($enum)) {
                        return County::tryFrom($enum) ? $enum : '';
                    }

                    return $enum ? $enum->value : '';
                },
                'choice_label' => function (null|County|string $enum): string {
                    if (is_string($enum)) {
                        $e = County::tryFrom($enum);
                        return $e ? County::getName($e->value) : '';
                    }

                    return $enum ? County::getName($enum->value) : '';
                }
            ])->add('overview', TextareaType::class, ['label' => 'Introduction :', 'required' => false])
        ;
        DatePicker::addDatePicker($builder, 'createdAt', 'Créé le');


        // History
        $builder->add('history', TextareaType::class, ['label' => 'Histoire :', 'required' => false]);

        // Team
        $builder->add('teams', EntityType::class, [
            'choice_label' => 'name',
            'attr' => ['class' => 'rda-display-none rda-list-wrapper'],
            'class' => Team::class,
            'multiple' => true,
            'expanded' => true,
            'query_builder' => function (EntityRepository $er) use ($options): QueryBuilder {
                return $er->createQueryBuilder('t')
                    ->andWhere('t.countryCode = :countryCode')
                    ->setParameter('countryCode', Country::FRANCE->value)
                    ;
            },
            'by_reference' => false,
        ]);

        // Social medias
        $builder
            ->add('email', EmailType::class, ['label' => 'Email:', 'required' => false])
            ->add('interleagueEmail', EmailType::class, ['label' => 'Email Interligue:', 'required' => false])
            ->add('facebookId', TextType::class, ['label' => 'Facebook:', 'required' => false])
            ->add('instagramId', TextType::class, ['label' => 'Instagram:', 'required' => false])
            ->add('MyRollerDerbyId', TextType::class, ['label' => 'My Roller Derby:', 'required' => false])
        ;

        // Hidden
        // DatePicker::addDatePicker($builder, 'closedAt', 'Date de dissolution');

        // Submit
        $builder
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }
}
