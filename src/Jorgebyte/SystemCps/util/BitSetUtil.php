<?php

namespace Jorgebyte\SystemCps\util;

use pocketmine\network\mcpe\protocol\serializer\BitSet;

class BitSetUtil
{
    public static function isset(BitSet $bitSet, int $index): bool {
        try {
            return $bitSet->get($index);
        } catch (\InvalidArgumentException $e) {
            return false;
        }
    }
}