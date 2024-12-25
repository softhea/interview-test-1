<?php

declare(strict_types=1);

namespace App\Interfaces;

interface CanHire
{
    public function hasContactedUserIdBefore(int $userId): bool;
}
