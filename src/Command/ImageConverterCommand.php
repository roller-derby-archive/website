<?php

declare(strict_types=1);

namespace App\Command;


use App\Helper\ImageConverter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'app:image-converter')]
final class ImageConverterCommand extends Command
{
    function execute(InputInterface $input, OutputInterface $output): int
    {
        $files = scandir(__DIR__.'/../../assets/images/upload/');

        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || $this->checkWebpExist($file)) {
                continue;
            }

            $newFile = str_replace(['.jpg', '.jpeg', '.png'], '.webp', $file);
            $converter = new ImageConverter();

            if (substr($file, -4, 4) === '.png') {
                $img = imagecreatefrompng(__DIR__.'/../../assets/images/upload/'.$file);
                imagepalettetotruecolor($img);
                imagewebp($img, __DIR__.'/../../assets/images/upload/'.$newFile);
            } else {
                $converter->convert(__DIR__.'/../../assets/images/upload/'.$file, __DIR__.'/../../assets/images/upload/'.$newFile, 5);
            }
        }

        return Command::SUCCESS;
    }

    private function checkWebpExist(string $file): bool
    {
        $newFile = str_replace(['.jpg', '.jpeg', '.png'], '.webp', $file);
        return is_file(__DIR__.'/../../assets/images/upload/'.$newFile);
    }
}

