<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Interfaces\NotificationInterface;

class HireNotification extends AbstractNotification implements NotificationInterface
{
    public static function getTypeId(): int
    {
        return 2;
    }

    public function getSubject(): string
    {
        return sprintf(
            'Company %s has hired you',
            $this->getSender()->getName()
        );
    }

    public function getMessage(): string
    {
        return sprintf(
            'Hello, %s! Company %s has hired you. Have a nice day!',
            $this->getReceiver()->getName(),
            $this->getSender()->getName(),
        );
    }
}
