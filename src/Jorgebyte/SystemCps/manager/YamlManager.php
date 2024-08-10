<?php

namespace Jorgebyte\SystemCps\manager;

use Jorgebyte\SystemCps\exception\YamlException;
use Jorgebyte\SystemCps\Main;
use pocketmine\utils\Config;

class YamlManager
{
    public static function getConfigValue(string $fileName, string $key): mixed
    {
        try
        {
            $filePath = Main::getInstance()->getDataFolder() . $fileName . ".yml";

            if (!file_exists($filePath))
                throw new YamlException("Config file '$fileName.yml' does not exist");

            $file = new Config($filePath, Config::YAML);
            $value = $file->get($key);

            if ($value === null)
                throw new YamlException("Key '$key' not found in '$fileName.yml'");

            return $value;
        }
        catch (YamlException $e)
        {
            Main::getInstance()->getLogger()->error($e->getMessage());
            return null;
        }
    }
}