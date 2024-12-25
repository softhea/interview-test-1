<?php

declare(strict_types=1);

namespace App\Interfaces;

interface CanNotify
{
    public function getUserId(): int;
    public function getEmail(): string;
    public function getName(): string;
    public function getCoins(): int;
}
