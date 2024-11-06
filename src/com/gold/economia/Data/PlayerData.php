<?php

namespace com\gold\economia;

use pocketmine\player\Player;
use pocketmine\utils\Config;

class PlayerData {

    private $plugin;
    private $data = [];

    public function __construct(EconomiaPlugin $plugin) {
        $this->plugin = $plugin;
        $this->loadData();
    }

    // Carrega os dados dos jogadores a partir do arquivo
    public function loadData() {
        $file = $this->plugin->getDataFolder() . "players.json";
        if (file_exists($file)) {
            $json = file_get_contents($file);
            $this->data = json_decode($json, true);
        } else {
            $this->saveData();
        }
    }
    

    // Salva os dados dos jogadores no arquivo
    public function saveData() {
        $json = json_encode($this->data, JSON_PRETTY_PRINT);
        file_put_contents($this->plugin->getDataFolder() . "players.json", $json);
    }

    // Retorna o saldo de um jogador
    public function getSaldo(Player $player) {
        return $this->data[$player->getName()]["saldo"] ?? 0;
    }

    // Adiciona saldo a um jogador
    public function addSaldo(Player $player, int $amount) {
        if (!isset($this->data[$player->getName()])) {
            $this->data[$player->getName()] = [];
        }
        $this->data[$player->getName()]["saldo"] = $this->getSaldo($player) + $amount;
        $this->saveData();
    }

    // Subtrai saldo de um jogador
    public function subtractSaldo(Player $player, int $amount) {
        if ($this->getSaldo($player) >= $amount) {
            $this->data[$player->getName()]["saldo"] -= $amount;
            $this->saveData();
            return true;
        }
        return false;
    }

    // Retorna o nível de um jogador
    public function getNivel(Player $player) {
        return $this->data[$player->getName()]["nivel"] ?? 0;
    }

    // Adiciona nível a um jogador
    public function addNivel(Player $player, int $amount) {
        if (!isset($this->data[$player->getName()])) {
            $this->data[$player->getName()] = [];
        }
        $this->data[$player->getName()]["nivel"] = $this->getNivel($player) + $amount;
        $this->saveData();
    }

    // Subtrai nível de um jogador
    public function subtractNivel(Player $player, int $amount) {
        if ($this->getNivel($player) >= $amount) {
            $this->data[$player->getName()]["nivel"] -= $amount;
            $this->saveData();
            return true;
        }
        return false;
    }
}
