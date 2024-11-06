<?php

namespace com\gold\economia\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use com\gold\economia\EconomiaPlugin;

class BalanceCommand extends Command {

    public function __construct(EconomiaPlugin $plugin) {
        parent::__construct("saldo", "Veja seu saldo atual");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args) {
        if ($sender instanceof Player) {
            $economyAPI = EconomiaPlugin::getEconomyAPI();
            $balance = $economyAPI->getBalance($sender);
            $sender->sendMessage("Seu saldo é: " . $balance);
        } else {
            $sender->sendMessage("Este comando só pode ser usado por jogadores.");
        }
    }
}
