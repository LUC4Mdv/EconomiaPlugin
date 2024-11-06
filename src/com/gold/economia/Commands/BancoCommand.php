<?php

namespace com\gold\economia\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;
use com\gold\economia\EconomiaPlugin;

class BancoCommand extends Command {

    private $plugin;

    public function __construct(EconomiaPlugin $plugin) {
        parent::__construct("banco", "Acesse seu banco");
        $this->plugin = $plugin;
    }

    public function execute($sender, $label, $args) {
        if ($sender instanceof Player) {
            $economyAPI = $this->plugin->getEconomyAPI();

            if (empty($args[0])) {
                $sender->sendMessage("Use /banco saldo, /banco deposito, ou /banco saque.");
                return;
            }

            $action = strtolower($args[0]);
            switch ($action) {
                case "saldo":
                    $balance = $economyAPI->getBankBalance($sender);
                    $sender->sendMessage("Seu saldo no banco é: " . $balance);
                    break;

                case "deposito":
                    $inventory = $sender->getInventory();
                    $totalAmount = 0;

                    foreach ($inventory->getContents() as $item) {
                        if ($item->getId() === ItemIds::PAPER && $item->getCustomName() !== null && strpos($item->getCustomName(), "Dinheiro") !== false) {
                            $itemAmount = (int)filter_var($item->getCustomName(), FILTER_SANITIZE_NUMBER_INT);
                            $totalAmount += $itemAmount * $item->getCount();
                            $inventory->removeItem($item);
                        }
                    }

                    if ($totalAmount > 0) {
                        $economyAPI->addBankBalance($sender, $totalAmount);
                        $sender->sendMessage("Você depositou R$$totalAmount no banco.");
                    } else {
                        $sender->sendMessage("Você não possui dinheiro para depositar.");
                    }
                    break;

                case "saque":
                    $amount = 1; // Exemplo de saque de 1 unidade por vez
                    if ($economyAPI->getBankBalance($sender) >= $amount) {
                        $economyAPI->subtractBankBalance($sender, $amount);
                        $item = ItemFactory::getInstance()->get(ItemIds::PAPER, 0, $amount);
                        $item->setCustomName("R$$amount Dinheiro");
                        $sender->getInventory()->addItem($item);
                        $sender->sendMessage("Você sacou R$$amount do banco.");
                    } else {
                        $sender->sendMessage("Saldo insuficiente no banco.");
                    }
                    break;

                default:
                    $sender->sendMessage("Comando inválido. Use /banco saldo, /banco deposito, ou /banco saque.");
                    break;
            }
        } else {
            $sender->sendMessage("Este comando só pode ser usado por jogadores.");
        }
    }
}
