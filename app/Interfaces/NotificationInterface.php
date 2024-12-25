<?php

declare(strict_types=1);

namespace App\Interfaces;

interface NotificationInterface
{
    public static function getTypeId(): int;
    public function getCost(): int;
    public function canNotify(): bool;
    public function cannotNotifyMessage(): string;
    public function getSubject(): string;
    public function getMessage(): string;
    public function getSender(): CanNotify|CanPay;
    public function getReceiver(): CanBeNotified;    
}
