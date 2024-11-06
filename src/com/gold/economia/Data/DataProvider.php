<?php

namespace com\gold\economia\Data;

use pocketmine\player\Player;

class DataProvider {

    private array $balances = [];

    public function loadBalance(Player $player) {
        return $this->balances[$player->getName()] ?? 0;
    }

    public function saveBalance(Player $player, int $balance) {
        $this->balances[$player->getName()] = $balance;
    }
}
