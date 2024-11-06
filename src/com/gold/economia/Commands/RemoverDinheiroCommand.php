<?php

namespace com\gold\economia\Commands;

// RemoverDinheiroCommand.php - Comando para remover dinheiro
// Exclusivo para o dono (Gold) para remover dinheiro de um jogador específico

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class RemoverDinheiroCommand extends Command {

    public function __construct() {
        parent::__construct("removerdinheiro", "Remove dinheiro de um jogador");
    }

    public function execute(CommandSender $sender, string $label, array $args) {
        if ($sender instanceof Player && $sender->getName() === "Gold") {
            if (isset($args[0]) && isset($args[1]) && is_numeric($args[1])) {
                $player = $this->getServer()->getPlayer($args[0]);
                $quantidade = (int)$args[1];
                if ($player) {
                    // Lógica para remover dinheiro do jogador
                    $player->sendMessage("Você perdeu R$$quantidade.");
                    $sender->sendMessage("Você removeu R$$quantidade do jogador {$args[0]}.");
                } else {
                    $sender->sendMessage("Jogador não encontrado.");
                }
            } else {
                $sender->sendMessage("Uso correto: /removerdinheiro <jogador> <quantia>");
            }
        }
    }
}
