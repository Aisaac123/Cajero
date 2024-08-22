<?php

namespace App\Services;

class WithdrawService
{
    private static $denominationCounts = [
        'denominations' => [10000, 20000, 50000, 100000],
        'counts' => [0, 0, 0, 0]
    ];

    public static function resetDenominations()
    {
        self::$denominationCounts['counts'] = array_fill(0, count(self::$denominationCounts['denominations']), 0);
    }

    public static function calculateDenominations(int $amount): array
    {
        self::resetDenominations();
        $denominations = &self::$denominationCounts['denominations'];
        $counts = &self::$denominationCounts['counts'];

        $pos = 0;

        while ($amount > 0) {
            $denomination = $denominations[$pos];
            $i = $pos;

            while ($i < count($denominations) && $denomination <= $amount && $amount > 0) {
                $counts[$i]++;
                $amount -= $denomination;
                $denomination = $denominations[++$i % count($denominations)];
            }
            $pos = ++$pos % count($denominations);
        }

        return self::$denominationCounts;
    }

    public static function getDenominationCounts(): array
    {
        return self::$denominationCounts;
    }
}
