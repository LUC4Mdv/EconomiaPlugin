<?php

namespace com\gold\economia\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use com\gold\economia\EconomiaPlugin;

class TopDinheiroCommand extends Command {

    private $plugin;

    public function __construct(EconomiaPlugin $plugin) {
        parent::__construct("topdinheiro", "Mostra o ranking dos jogadores com mais dinheiro");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args) {
        // Verificar se o comando é executado por um jogador (opcional)
        if (!$sender instanceof \pocketmine\player\Player) {
            $sender->sendMessage("Este comando pode ser usado apenas por jogadores.");
            return;
        }

        // Buscar todos os jogadores e seus saldos
        $topPlayers = $this->plugin->getEconomyAPI()->getAllBalances();
        
        // Ordenar os jogadores por saldo (em ordem decrescente)
        arsort($topPlayers);
        
        // Limitar os 10 primeiros
        $topPlayers = array_slice($topPlayers, 0, 10);
        
        // Construir a mensagem com o top 10
        $message = "Top 10 jogadores com mais dinheiro:\n";
        $rank = 1;
        
        foreach ($topPlayers as $playerName => $balance) {
            $message .= "§7$rank. §f$playerName - R$$balance\n";
            $rank++;
        }
        
        // Enviar a mensagem com o ranking
        $sender->sendMessage($message);
    }
}
