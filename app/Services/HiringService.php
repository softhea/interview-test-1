<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\CanBeHired;
use App\Interfaces\CanBeNotified;
use App\Interfaces\CanHire;
use App\Interfaces\CanNotify;
use App\Interfaces\CanPay;
use App\Notifications\HireNotification;
use Exception;

class HiringService
{
    private CanHire|CanPay|CanNotify $employer;
    private CanBeHired|CanBeNotified $candidate;

    public function __construct(
        private PaymentService $paymentService,
        private NotificationService $notificationService
    ) {}

    public function hire(CanHire|CanPay|CanNotify $employer, CanBeHired|CanBeNotified $candidate): void
    {
        $this->employer = $employer;
        $this->candidate = $candidate;

        $this->validate();

        $this->hireCandidate();
        $this->notifyCandidate();
        $this->creditEmployer();
    }

    /**
     * @throws Exception
     */
    private function validate(): void
    {
        if ($this->candidate->isHired()) {
            throw new Exception('Candidate is already hired!');
        }
        if (!$this->employer->hasContactedUserIdBefore($this->candidate->getUserId())) {
            throw new Exception('Employer hasn\'t contacted the Candidate before!');
        }
    }

    private function hireCandidate(): void
    {
        $this->candidate->hire();
    }

    private function notifyCandidate(): void
    {
        $this->notificationService->notify(
            notification: new HireNotification($this->employer, $this->candidate)
        );
    }

    private function creditEmployer(): void
    {
        $this->paymentService->credit( $this->employer, 5);
    }
}
