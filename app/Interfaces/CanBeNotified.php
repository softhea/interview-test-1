<?php

declare(strict_types=1);

namespace App\Interfaces;

interface CanBeNotified
{
    public function getUserId(): int;
    public function getEmail(): string;
    public function getName(): string;
}
