<?php

namespace Jorgebyte\SystemCps;

use Jorgebyte\SystemCps\manager\CpsManager;
use Jorgebyte\SystemCps\util\BitSetUtil;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\PlayerAuthInputPacket;
use pocketmine\network\mcpe\protocol\serializer\BitSet;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemOnEntityTransactionData;
use pocketmine\network\mcpe\protocol\types\PlayerAuthInputFlags;
use pocketmine\player\Player;

class EventListener implements Listener
{
    public function onDataPacketReceive(DataPacketReceiveEvent $event): void
    {
        $packet = $event->getPacket();
        $player = $event->getOrigin()->getPlayer();
        if (!$player instanceof Player) return;

        $swung = false;

        if ($packet instanceof PlayerAuthInputPacket) {
            $inputFlags = $packet->getInputFlags();
            if ($inputFlags instanceof BitSet) {
                $swung = BitSetUtil::isset($inputFlags, PlayerAuthInputFlags::MISSED_SWING);
            }
        }

        if ($swung || ($packet instanceof InventoryTransactionPacket && $packet->trData instanceof UseItemOnEntityTransactionData)) {
            CpsManager::addClick($player);
        }
    }

    public function onPlayerQuit(PlayerQuitEvent $event): void
    {
        CpsManager::removePlayer($event->getPlayer());
    }
}