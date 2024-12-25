<?php

declare(strict_types=1);

namespace App\Interfaces;

interface CanPay
{
    public function addCoins(int $noOfCoins): void;
}
