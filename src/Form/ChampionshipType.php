<?php

namespace App\Form;

use App\Entity\Club;
use App\Enum\ChampionshipDivision;
use App\Enum\TeamCategory;
use App\Enum\TeamLevel;
use App\Form\Helper\DatePicker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class ChampionshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('season', TextType::class)
            ->add('category', EnumType::class, [
                'class' => TeamCategory::class,
                'choice_value' => function (?TeamCategory $enum): string {
                    return $enum ? $enum->value : '';
                }
            ])
            ->add('division', EnumType::class, [
                'class' => ChampionshipDivision::class,
                'choice_value' => function (?ChampionshipDivision $enum): string {
                    return $enum ? $enum->value : '';
                }
            ])
            ->add('championshipRankings', CollectionType::class, [
                'entry_type' => ChampionshipRankingType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }
}
