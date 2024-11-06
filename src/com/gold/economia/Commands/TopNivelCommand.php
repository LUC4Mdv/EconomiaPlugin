<?php

namespace com\gold\economia\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use com\gold\economia\EconomiaPlugin;
use pocketmine\player\Player;

class TopNivelCommand extends Command {

    private $plugin;

    public function __construct(EconomiaPlugin $plugin) {
        parent::__construct("topnivel", "Mostra o ranking dos jogadores com maior nível");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args) {
        // Verificar se o comando foi executado por um jogador
        if (!$sender instanceof Player) {
            $sender->sendMessage("Este comando só pode ser usado por jogadores.");
            return;
        }

        // Buscar todos os jogadores e seus níveis (tempo online)
        $topPlayers = $this->plugin->getLevelAPI()->getAllLevels();
        
        // Ordenar os jogadores por nível (em ordem decrescente)
        arsort($topPlayers);
        
        // Limitar os 10 primeiros
        $topPlayers = array_slice($topPlayers, 0, 10);
        
        // Construir a mensagem com o top 10
        $message = "Top 10 jogadores com maior nível:\n";
        $rank = 1;
        
        foreach ($topPlayers as $playerName => $level) {
            $message .= "§7$rank. §f$playerName - Nível: $level\n";
            $rank++;
        }
        
        // Enviar a mensagem com o ranking
        $sender->sendMessage($message);
    }
}
