<?php

namespace Jorgebyte\SystemCps\form;

use Jorgebyte\SystemCps\manager\YamlManager;
use pocketmine\player\Player;
use Vecnavium\FormsUI\SimpleForm;

class WarningForm extends SimpleForm
{
    public function __construct()
    {
        parent::__construct(function (Player $player, $data) {
            if ($data === null) return;
        });
        $this->setTitle(YamlManager::getConfigValue("forms", "title_warning"));
        $this->setContent(YamlManager::getConfigValue("forms", "content_warning"));
    }
}