<?php

namespace com\gold\economia;

use pocketmine\player\Player;

class NivelAPI {

    private array $playerTimes = [];
    private array $levels = [];

    public function getLevel(Player $player) {
        return $this->levels[$player->getName()] ?? 0;
    }

    public function addTime(Player $player, int $minutes) {
        $this->playerTimes[$player->getName()] = ($this->playerTimes[$player->getName()] ?? 0) + $minutes;
        $this->updateLevel($player);
    }

    public function removeTime(Player $player, int $minutes) {
        $this->playerTimes[$player->getName()] = max(0, ($this->playerTimes[$player->getName()] ?? 0) - $minutes);
        $this->updateLevel($player);
    }

    public function addLevel(Player $player, int $levelsToAdd) {
        $this->levels[$player->getName()] = $this->getLevel($player) + $levelsToAdd;
    }

    public function removeLevel(Player $player, int $levelsToRemove) {
        $this->levels[$player->getName()] = max(0, $this->getLevel($player) - $levelsToRemove);
    }

    public function updateLevel(Player $player) {
        $timeOnline = $this->playerTimes[$player->getName()] ?? 0;
        $level = (int)($timeOnline / 100);
        $this->levels[$player->getName()] = $level;
    }
}
