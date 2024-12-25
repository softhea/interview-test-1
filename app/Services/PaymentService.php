<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\CanPay;

class PaymentService
{
    function credit(CanPay $client, int $amount): void
    {
        $client->addCoins($amount);
    }

    function debit(CanPay $client, int $amount): void
    {
        $client->addCoins(-$amount);
    }
}
