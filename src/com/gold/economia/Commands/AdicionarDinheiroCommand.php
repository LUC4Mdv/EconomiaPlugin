<?php

namespace com\gold\economia\Commands;

// AdicionarDinheiroCommand.php - Comando para adicionar dinheiro
// Exclusivo para o dono (Gold) para adicionar dinheiro a um jogador específico

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class AdicionarDinheiroCommand extends Command {

    public function __construct() {
        parent::__construct("adddinheiro", "Adiciona dinheiro a um jogador");
    }

    public function execute(CommandSender $sender, string $label, array $args) {
        if ($sender instanceof Player && $sender->getName() === "Gold") {
            if (isset($args[0]) && isset($args[1]) && is_numeric($args[1])) {
                $player = $this->getServer()->getPlayer($args[0]);
                $quantidade = (int)$args[1];
                if ($player) {
                    // Lógica para adicionar dinheiro ao jogador
                    $player->sendMessage("Você recebeu R$$quantidade.");
                    $sender->sendMessage("Você adicionou R$$quantidade ao jogador {$args[0]}.");
                } else {
                    $sender->sendMessage("Jogador não encontrado.");
                }
            } else {
                $sender->sendMessage("Uso correto: /adddinheiro <jogador> <quantia>");
            }
        }
    }
}
