<?php

namespace Jorgebyte\SystemCps;

use Jorgebyte\SystemCps\manager\CpsManager;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\player\Player;

class EventListener implements Listener
{
    public function onDataPacketReceive(DataPacketReceiveEvent $event): void
    {
        $packet = $event->getPacket();
        $player = $event->getOrigin()->getPlayer();
        if (!$player instanceof Player) return;

        if ($packet instanceof InventoryTransactionPacket && $packet->trData->getTypeId() == InventoryTransactionPacket::TYPE_USE_ITEM_ON_ENTITY) {
                CpsManager::addClick($player);
        }
    }

    public function onPlayerQuit(PlayerQuitEvent $event): void
    {
        CpsManager::removePlayer($event->getPlayer());
    }
}