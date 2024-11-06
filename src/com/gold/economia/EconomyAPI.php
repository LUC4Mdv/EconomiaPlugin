<?php

namespace com\gold\economia;

use pocketmine\player\Player;

class EconomyAPI {

    // Armazena os saldos dos jogadores. Este exemplo usa um array simples, mas em um servidor real você provavelmente usaria um banco de dados.
    private array $balances = [];

    // Retorna o saldo do jogador. Caso o jogador não tenha saldo, retorna 0.
    public function getBalance(Player $player) {
        return $this->balances[$player->getName()] ?? 0;
    }

    // Adiciona um valor ao saldo do jogador
    public function addBalance(Player $player, int $amount) {
        $currentBalance = $this->getBalance($player);
        $this->balances[$player->getName()] = $currentBalance + $amount;
    }

    // Subtrai um valor do saldo do jogador, se o saldo for suficiente. Retorna true se a operação for bem-sucedida, ou false se não houver saldo suficiente.
    public function subtractBalance(Player $player, int $amount) {
        $currentBalance = $this->getBalance($player);

        if ($currentBalance >= $amount) {
            $this->balances[$player->getName()] = $currentBalance - $amount;
            return true;
        }

        return false;
    }

    // Realiza a transferência de dinheiro entre dois jogadores. Se a transferência for bem-sucedida, retorna true, caso contrário, retorna false.
    public function transfer(Player $sender, Player $receiver, int $amount) {
        // Primeiro, tentamos subtrair o valor do saldo do remetente
        if ($this->subtractBalance($sender, $amount)) {
            // Se a subtração for bem-sucedida, adicionamos o valor ao saldo do receptor
            $this->addBalance($receiver, $amount);
            return true;
        }

        // Se não houver saldo suficiente, a transferência falha
        return false;
    }

    // Método para retornar todos os saldos
    public function getAllBalances() {
        return $this->balances;
    }
}
