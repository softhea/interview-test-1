<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Interfaces\NotificationInterface;

class ContactNotification extends AbstractNotification implements NotificationInterface
{
    public static function getTypeId(): int
    {
        return 1;
    }

    public function getCost(): int
    {   
        return 5;
    }

    public function canNotify(): bool
    {
        return $this->getCost() <= $this->getSender()->getCoins();
    }

    public function cannotNotifyMessage(): string
    {
        return 'To be able to contact candidate you need ' 
        . $this->getCost() 
        . ' coins and you only have ' . $this->getSender()->getCoins() . '!';
    }

    public function getSubject(): string
    {
        return sprintf(
            'Company %s has contacted you',
            $this->getSender()->getName()
        );
    }

    public function getMessage(): string
    {
        return sprintf(
            'Hello, %s! Company %s has contacted you. Have a nice day!',
            $this->getReceiver()->getName(),
            $this->getSender()->getName(),
        );
    }
}
