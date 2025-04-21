<?php

namespace App\Helper;

class Common
{
    public static function GetFirstLetter(string $name): string
    {
        $letter = substr($name, 0, 1);
        if (!preg_match('/[A-Z]/', $letter)) {
            $letter = substr($name, 0, 2);
            mb_convert_encoding($letter, 'ISO-8859-1', 'UTF-8');

            if ($letter === "É") {
                $letter = 'E';
            }
        }

        return $letter;
    }
}