<?php

namespace com\gold\economia\Utils;

class EconomyUtils {

    public static function formatCurrency(int $amount) {
        return "R$ " . number_format($amount, 2, ',', '.');
    }
}
