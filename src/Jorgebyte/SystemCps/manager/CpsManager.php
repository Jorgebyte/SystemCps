<?php

namespace Jorgebyte\SystemCps\manager;

use Jorgebyte\SystemCps\form\WarningForm;
use Jorgebyte\SystemCps\Main;
use pocketmine\player\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\Config;

class CpsManager
{
    private static array $playerCps = [];
    private static array $pendingWarnings = [];

    public static function addClick(Player $player): void
    {
        $name = $player->getName();
        $currentTime = microtime(true);

        if (!isset(self::$playerCps[$name])) {
            self::$playerCps[$name] = [];
        }

        self::$playerCps[$name][] = $currentTime;
        self::$playerCps[$name] = array_filter(
            self::$playerCps[$name],
            function ($time) use ($currentTime) {
                return ($currentTime - $time) <= 1;
            }
        );

        self::sendCps($player);
        self::checkCpsLimit($player);
    }

    private static function sendCps(Player $player): void
    {
        $name = $player->getName();
        $cps = count(self::$playerCps[$name]);
        $player->sendPopup("§aCPS: §b" . $cps);
    }

    private static function checkCpsLimit(Player $player): void
    {
        $name = $player->getName();
        $cpsLimit = YamlManager::getConfigValue("config", "cps_limit");

        if (count(self::$playerCps[$name]) > $cpsLimit) {
            if (!isset(self::$pendingWarnings[$name])) {
                self::$pendingWarnings[$name] = true;
                self::issueWarning($player);
            }
        } else {
            if (isset(self::$pendingWarnings[$name])) {
                unset(self::$pendingWarnings[$name]);
            }
        }
    }

    private static function issueWarning(Player $player): void
    {
        $name = $player->getName();
        $maxWarnings = YamlManager::getConfigValue("config", "max_warnings");
        $warnings = WarningManager::getWarningCount($name);

        if ($warnings >= $maxWarnings) {
            $player->kick(YamlManager::getConfigValue("messages", "msg_kick"));
            Server::getInstance()->broadcastMessage(str_replace("{NAME}", $player->getName(), YamlManager::getConfigValue("messages", "broadcast_msg_kick")));
            self::removePlayer($player);
            WarningManager::removeWarnings($name);
        } else {
            WarningManager::incrementWarning($name);
            $player->sendForm(new WarningForm());
        }
    }

    public static function removePlayer(Player $player): void
    {
        $name = $player->getName();
        unset(self::$playerCps[$name]);

        if (isset(self::$pendingWarnings[$name])) {
            unset(self::$pendingWarnings[$name]);
        }
    }
}