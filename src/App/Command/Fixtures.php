<?php

declare(strict_types=1);

namespace App\App\Command;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final readonly class Fixtures
{
    const FIXTURES_DIR = __DIR__ . '/../../fixtures/';
    const TEAM_FILE = self::FIXTURES_DIR . '/teams.json';
    const CLUB_FILE = self::FIXTURES_DIR . '/clubs.json';
    const GAME_FILE = self::FIXTURES_DIR . '/games.json';
    const TEAM_TMP_FILE = self::FIXTURES_DIR . '/teams_tmp.json';
    const CLUB_TMP_FILE = self::FIXTURES_DIR . '/clubs_tmp.json';
    const GAME_TMP_FILE = self::FIXTURES_DIR . '/games_tmp.json';
    const TEAM_OLD_FILE = self::FIXTURES_DIR . '/teams_old.json';
    const CLUB_OLD_FILE = self::FIXTURES_DIR . '/clubs_old.json';
    const GAME_OLD_FILE = self::FIXTURES_DIR . '/games_old.json';
}
