<?php

declare(strict_types=1);

namespace App\Form\Helper;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class DatePicker
{
    public static function addDatePicker(FormBuilderInterface $builder, string $field, string $label): void
    {
        $builder->add($field, DateType::class, [
            'label' => $label,
            'input' => 'datetime_immutable',
            'widget' => 'single_text',
            'html5' => false,
            'attr' => ['class' => 'js-datepicker'],
            'format' => 'd/m/Y',
        ]);
    }
}
