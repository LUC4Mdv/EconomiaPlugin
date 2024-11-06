<?php

namespace com\gold\economia;

use pocketmine\plugin\PluginBase;
use com\gold\economia\Commands\BalanceCommand;
use com\gold\economia\Commands\BankCommand;
use com\gold\economia\Data\DataProvider;
use com\gold\economia\Listener\PlayerEventListener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class EconomiaPlugin extends PluginBase {

    private static ?EconomyAPI $economyAPI = null;

    protected function onEnable() {
        self::$economyAPI = new EconomyAPI();
        $this->getServer()->getCommandMap()->registerAll("economia", [
            new Commands\BancoCommand($this),
            new Commands\DinheiroItemCommand($this),
            new Commands\TopDinheiroCommand($this),
            new Commands\TopNivelCommand($this),
            new Commands\AdicionarDinheiroCommand($this),
            new Commands\RemoverDinheiroCommand($this),
            new Commands\PixCommand($this),
            new Command\BalanceCommand($this)
        ]);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEventListener($this), $this);
        $this->saveResource("config.yml");
    }

    public function getPlayerData() {
        return $this->playerData;
    }

    public static function getEconomyAPI(): EconomyAPI {
        return self::$economyAPI;
    }

    public function getLevelAPI(): LevelAPI {
        return $this->levelAPI;
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() == "topdinheiro") {
            // Comando para exibir top 10 jogadores com mais dinheiro
            $this->getServer()->getScheduler()->scheduleDelayedTask(new TopDinheiroCommand($this), 20);
            return true;
        }

        if ($command->getName() == "topnivel") {
            // Comando para exibir top 10 jogadores com maior nível
            $this->getServer()->getScheduler()->scheduleDelayedTask(new TopNivelCommand($this), 20);
            return true;
        }
        return false;
    }
}
