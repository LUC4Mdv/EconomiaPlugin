<?php

namespace com\gold\economia\Commands;

// PixCommand.php - Comando para realizar transferência de dinheiro entre jogadores

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use com\gold\economia\EconomiaPlugin;
use pocketmine\utils\TextFormat;

class PixCommand extends Command {

    private $plugin;

    public function __construct(EconomiaPlugin $plugin) {
        parent::__construct("pix", "Transferir dinheiro instantaneamente para outro jogador (PIX)");
        $this->plugin = $plugin;
    }

    public function execute($sender, $label, $args){
        if ($sender instanceof Player) {
            // Verifica se os parâmetros estão corretos
            if (count($args) < 2 || !is_numeric($args[1])) {
                $sender->sendMessage(TextFormat::RED . "Uso correto: /pix <jogador> <quantia>");
                return;
            }

            $quantia = (int)$args[1];
            $player = $this->plugin->getServer()->getPlayer($args[0]);

            if ($player === null) {
                $sender->sendMessage(TextFormat::RED . "Jogador não encontrado.");
                return;
            }

            if ($quantia <= 0) {
                $sender->sendMessage(TextFormat::RED . "Quantia inválida.");
                return;
            }

            // Aqui você pode verificar se o jogador tem saldo suficiente antes de transferir
            $saldoJogador = 1000; // Substitua por sua lógica para pegar o saldo do jogador

            if ($saldoJogador < $quantia) {
                $sender->sendMessage(TextFormat::RED . "Você não tem saldo suficiente.");
                return;
            }

            // Transferência instantânea
            $this->transferirDinheiro($sender, $player, $quantia);
            $sender->sendMessage(TextFormat::GREEN . "Você transferiu R$$quantia para {$player->getName()} via PIX.");
            $player->sendMessage(TextFormat::GREEN . "Você recebeu R$$quantia de {$sender->getName()} via PIX.");
        } else {
            $sender->sendMessage(TextFormat::RED . "Este comando só pode ser usado por jogadores.");
        }
    }

    private function transferirDinheiro(Player $sender, Player $receiver, int $quantia) {
        // Lógica de transferência de dinheiro (remover do sender e adicionar ao receiver)
        // Isso depende de como você está controlando o saldo dos jogadores no seu plugin
        $this->plugin->getEconomyAPI()->removerSaldo($sender, $quantia);
        $this->plugin->getEconomyAPI()->adicionarSaldo($receiver, $quantia);
    }
}
