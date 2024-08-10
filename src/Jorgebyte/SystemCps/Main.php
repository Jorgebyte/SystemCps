<?php

namespace Jorgebyte\SystemCps;

use Jorgebyte\SystemCps\manager\WarningManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase
{
    use SingletonTrait;

    private const RESOURCES =
        [
            "config.yml",
            "forms.yml",
            "messages.yml"
        ];

    public function onLoad(): void
    {
        self::setInstance($this);
    }

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        WarningManager::init($this->getDataFolder());
        $this->saveResources();
    }

    private function saveResources(): void
    {
        foreach (self::RESOURCES as $resource) {
            $this->saveResource($resource);
        }
    }
}