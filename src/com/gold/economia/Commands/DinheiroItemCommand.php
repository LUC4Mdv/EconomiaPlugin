<?php

namespace com\gold\economia\Commands;

// DinheiroItemCommand.php - Comando para obter o item de dinheiro
// Disponível apenas para o dono (Gold) para receber um papel com o valor personalizado

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;

class DinheiroItemCommand extends Command {

    public function __construct() {
        parent::__construct("dinheiro", "Receba um item de dinheiro");
    }

    public function execute($sender, $label, $args) {
        if ($sender instanceof Player) {
            if ($sender->getName() !== "Gold") {
                $sender->sendMessage("Apenas o dono do servidor pode usar este comando.");
                return;
            }

            if (isset($args[0]) && is_numeric($args[0]) && $args[0] > 0) {
                $quantidade = (int)$args[0];
                $item = ItemFactory::getInstance()->get(ItemIds::PAPER, 0, 1);
                $item->setCustomName("R$$quantidade Dinheiro");
                $sender->getInventory()->addItem($item);
                $sender->sendMessage("Você recebeu R$$quantidade em dinheiro.");
            } else {
                $sender->sendMessage("Por favor, insira uma quantia válida. Exemplo: /dinheiro 100");
            }
        } else {
            $sender->sendMessage("Este comando só pode ser usado por jogadores.");
        }
    }
}
