<?php

namespace App\Form;

use App\Entity\ChampionshipRanking;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class ChampionshipRankingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rank', IntegerType::class)
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChampionshipRanking::class,
        ]);
    }
}
