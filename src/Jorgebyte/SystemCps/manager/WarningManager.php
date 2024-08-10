<?php

namespace Jorgebyte\SystemCps\manager;

use pocketmine\utils\Config;

class WarningManager
{
    private static string $dataFile;

    public static function init(string $dataFolder): void
    {
        self::$dataFile = $dataFolder . "warnings.json";
        if (!file_exists(self::$dataFile)) {
            file_put_contents(self::$dataFile, json_encode([]));
        }
    }

    public static function incrementWarning(string $playerName): void
    {
        $warnings = self::getAllWarnings();
        $warnings[$playerName] = ($warnings[$playerName] ?? 0) + 1;
        self::saveAllWarnings($warnings);
    }

    public static function getWarningCount(string $playerName): int
    {
        $warnings = self::getAllWarnings();
        return $warnings[$playerName] ?? 0;
    }

    public static function removeWarnings(string $playerName): void
    {
        $warnings = self::getAllWarnings();
        unset($warnings[$playerName]);
        self::saveAllWarnings($warnings);
    }

    private static function getAllWarnings(): array
    {
        $config = new Config(self::$dataFile, Config::JSON);
        return $config->getAll();
    }

    private static function saveAllWarnings(array $warnings): void
    {
        $config = new Config(self::$dataFile, Config::JSON);
        $config->setAll($warnings);
        $config->save();
    }
}