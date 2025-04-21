<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Club;
use App\Entity\Team;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'app:import')]
final class ImportClubAndTeamCommand extends Command
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputFileName = __DIR__.'/../../var/import/Roller Derby Archive.xlsx';
        $spreadsheet = IOFactory::load($inputFileName);
        $spreadsheet->setActiveSheetIndex(0);
        $worksheet = $spreadsheet->getActiveSheet();
        $dataArray = $worksheet->toArray();
        $clubUuidMap = [];

        $clubs = [];
        foreach ($dataArray as $key => $row) {
            if (0 === $key) {continue;}
            if (null === $row[1]) {break;}

            if (null === $row[8] || null === $row[7]) {continue;}

            $club = (new Club())
                ->setId(Uuid::v4()->toString())
                ->setName($this->formatName(trim($row[1])))
                ->setRegionCode($row[8])
                ->setCountyCode($row[7])
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setCities(explode(';', $row[6]))
            ;

            $clubUuidMap[$row[0]] = $club->getId();

            $clubs[] = $club;

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

            if ($row[11] != null) {
                $club->setInterleagueEmail($row[11]);
            }

            if (null !== $row[12]) {
                $club->setFacebookId($row[12]);
            }

            if (null !== $row[13]) {
                $club->setInstagramId($row[13]);
            }

            if (null !== $row[14]) {
                $club->setLegalId($row[14]);
            }

            if (null !== $row[3]) {
                $club->setGenderDiversityPolicy($row[3]);
            }

            if (null !== $row[9]) {
                $websites = [];
                $sites = explode(';', $row[9]);

                foreach ($sites as $site) {
                    $nameAndUrl = explode(':::', $site);
                    $websites[$nameAndUrl[0]] = $nameAndUrl[1];
                }

               $club->setWebsites($websites);
            }

            if (null !== $row[15]) {
                $club->setMediaLinks(explode(';', $row[15]));
            }
        }

        $json = $this->serializer->serialize($clubs, 'json');
        file_put_contents(__DIR__.'/../../fixtures/clubs.json', $json);

        $worksheet = $spreadsheet->setActiveSheetIndex(1);
        $teamArray = $worksheet->toArray();

        $teams = [];
        foreach ($teamArray as $key => $row) {
            if (0 === $key) {continue;}
            if (null === $row[7]) {break;}


            $team = (new Team())
                ->setId(Uuid::v4()->toString())
                ->setName($this->formatName(trim($row[0])))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCategory($row[6])
                ->setType($row[7])
                ->setPronoun($row[1])
            ;

            $teams[] = $team;

            $teamIds = explode(';', $row[2] ?? "");
            foreach ($teamIds as $teamId) {
                if ('' === $teamId) {
                    continue;
                }

                if (($clubUuidMap[$teamId] ?? null) != null) {
                    $team->addClub((new $club)
                        ->setId($clubUuidMap[$teamId])
                        ->setName("")
                        ->setRegionCode("")
                        ->setCountyCode("")
                        ->setCreatedAt(new \DateTimeImmutable())
                        ->setUpdatedAt(new \DateTimeImmutable())
                    );
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
            }

            if ($row[10] != null) {
                $team->setFacebookId($row[10]);
            }


            if ($row[11] != null) {
                $team->setInstagramId($row[11]);
            }

            if ($row[9] != null) {
                $team->setEmail($row[9]);
            }


            if (null !== $row[12]) {
                $team->setMediaLinks(explode(';', $row[12]));
            }

            if ($row[8] != null) {
                $team->setLevel($row[8]);
            }
        }
        $json = $this->serializer->serialize($teams, 'json');
        file_put_contents(__DIR__.'/../../fixtures/teams.json', $json);

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
