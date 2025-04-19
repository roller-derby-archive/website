<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Club;
use App\Entity\Team;
use App\Repository\ClubRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'app:import')]
final class ImportClubAndTeamCommand extends Command
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager, ?string $name = null)
    {
        $this->entityManager = $entityManager;

        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputFileName = __DIR__.'/../../var/import/Roller Derby Archive.xlsx';
        $spreadsheet = IOFactory::load($inputFileName);
        $spreadsheet->setActiveSheetIndex(0);
        $worksheet = $spreadsheet->getActiveSheet();
        $dataArray = $worksheet->toArray();
        $clubIdMap = [];
        $clubUuidMap = [];

        /** @var ClubRepository $clubRepository */
        $clubRepository = $this->entityManager->getRepository(Club::class);
        $clubRepository->cleanAll();

        foreach ($dataArray as $key => $row) {
            if (0 === $key) {continue;}
            if (null === $row[1]) {break;}

            if (null === $row[8] || null === $row[7]) {continue;}

            $club = (new Club())
                ->setName($this->formatName(trim($row[1])))
                ->setRegionCode($row[8])
                ->setCountyCode($row[7])
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setCities(explode(';', $row[6]))
            ;

            if (null !== $row[2]) {
                $club->setAlias($row[2]);
            }

            if (null !== $row[5]) {
                $conversion = \DateTimeImmutable::createFromFormat('d/m/Y', $row[5]);
                if (!$conversion) {
                        dd($row[5]);
                }
                $club->setCreatedAt($conversion);
            } else {
                $club->setCreatedAt(\DateTimeImmutable::createFromFormat('d/m/Y', '01/01/1900'));
            }

            if (null !== $row[4]) {
                $conversion = \DateTimeImmutable::createFromFormat('d/m/Y', $row[4]);
                if (!$conversion) {
                    dd($row[4]);
                }
                $club->setClosedAt($conversion);
            }

            if (null !== $row[10]) {
                $club->setEmail($row[10]);
            }

            if (null !== $row[12]) {
                $club->setFacebookId($row[12]);
            }

            if (null !== $row[13]) {
                $club->setInstagramId($row[13]);
            }

            $clubIdMap[$this->formatName(trim($row[1]))] = $row[0];

            $this->entityManager->persist($club);
        }

        $this->entityManager->flush();

        foreach ($clubRepository->findAll() as $club) {
            $id = $clubIdMap[$club->getName()] ?? null;
            $clubUuidMap[$id] = $club;
            $output->writeln(sprintf('id: %s name: %s', $club->getId(), $club->getName()));
        }

        $worksheet = $spreadsheet->setActiveSheetIndex(1);

        /** @var TeamRepository $itemRepository */
        $itemRepository = $this->entityManager->getRepository(Team::class);
        $itemRepository->cleanAll();
        $teamArray = $worksheet->toArray();

        foreach ($teamArray as $key => $row) {
            if (0 === $key) {continue;}
            if (null === $row[7]) {break;}

            $output->writeln(sprintf('name: %s', $this->formatName(trim($row[0]))));

            $team = (new Team())
                ->setName($this->formatName(trim($row[0])))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setGenderScope($row[6])
                ->setLetter($row[7])
                ->setPronoun($row[1])
            ;

            $teamIds = explode(';', $row[2] ?? "");
            foreach ($teamIds as $teamId) {
                if ('' === $teamId) {
                    continue;
                }

                if (($clubUuidMap[$teamId] ?? null) != null) {
                    $team->addClub($clubUuidMap[$teamId]);
                }
            }

            if (null !== $row[4]) {
                $conversion = \DateTimeImmutable::createFromFormat('d/m/Y', $row[4]);
                if (!$conversion) {
                    dd($row[4]);
                }
                $team->setCreatedAt($conversion);
            } else {
                $team->setCreatedAt(\DateTimeImmutable::createFromFormat('d/m/Y', '01/01/1900'));
            }

            if (null !== $row[3]) {
                $conversion = \DateTimeImmutable::createFromFormat('d/m/Y', $row[3]);
                if (!$conversion) {
                    dd($row[3]);
                }
                $team->setDisbandAt($conversion);
            }

            if ($row[5] != null) {
                $team->setFlattrackId((int)$row[5]);
                $team->setLogo('upload/logo_'.$row[5].'.webp');
                if ($team->getLetter() === 'A') {
                    foreach ($team->getClubs() as $club) {
                        if ($club->getLogo() !== null && $team->getGenderScope() === 'M') {
                            continue;
                        }

                        $club->setLogo('upload/logo_'.$row[5].'.webp');
                    }
                }
            }

            if ($row[8] != null) {
                $team->setLevel($row[8]);
            }

            $this->entityManager->persist($team);
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }

    private function formatName(string $name): string
    {
        $formatedName = '';

        $words = explode(' ', $name);
        foreach ($words as $key => $word) {
            $word = strtolower($word);
            if (0 !== $key) {
                $formatedName .= " ";
            }
            $formatedName .= ucfirst($word);
        }

        return $formatedName;
    }
}
