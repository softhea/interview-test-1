<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\NotificationInterface;
use App\Mail\NotifyCandidate;
use App\Models\Notification;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    private NotificationInterface $notification;

    public function __construct(private PaymentService $paymentService) {}

    public function notify(NotificationInterface $notification): void
    {
        $this->notification = $notification;

        $this->validate();

        $this->send();
        $this->log();
        $this->debitSender();
    }

    /**
     * @throws Exception
     */
    private function validate(): void
    {
        if (!$this->notification->canNotify()) {
            throw new Exception($this->notification->cannotNotifyMessage());
        }
    }

    private function send(): void
    {
        Mail::to($this->notification->getReceiver()->getEmail())
            ->send(
                new NotifyCandidate($this->notification)
            );
    }

    private function log(): void
    {
        Notification::query()->create([
            Notification::TYPE_ID => $this->notification::getTypeId(),
            Notification::SENDER_USER_ID => $this->notification->getSender()->getUserId(),
            Notification::RECEIVER_USER_ID => $this->notification->getReceiver()->getUserId(),
            Notification::SUBJECT => $this->notification->getSubject(),
            Notification::MESSAGE => $this->notification->getMessage(),
        ]);
    }

    private function debitSender(): void
    {
        if (0 === $this->notification->getCost()) {
            return;
        }

        $this->paymentService->debit(
            $this->notification->getSender(), 
            $this->notification->getCost()
        );
    }
}
