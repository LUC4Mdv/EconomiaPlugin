<?php

namespace com\gold\economia\Listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use com\gold\economia\EconomiaPlugin;

class PlayerEventListener implements Listener {

    public function onPlayerQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $economyAPI = EconomiaPlugin::getEconomyAPI();
        $balance = $economyAPI->getBalance($player);
        // Aqui você poderia salvar o balance em um arquivo ou banco de dados
    }
}
