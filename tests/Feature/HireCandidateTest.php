<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\NotifyCandidate;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Notification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class HireCandidateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_candidate_has_been_hired(): void
    {
        Mail::fake();
        
        Notification::query()->create([
            Notification::TYPE_ID => 1,
            Notification::SENDER_USER_ID => 1,
            Notification::RECEIVER_USER_ID => 2,
        ]);

        $response = $this->patchJson(uri: 'candidates/1/hire');

        $response->assertOk();
        $response->assertExactJson([
            'message' => 'Candidate has been hired',
            'coins' => 25,
        ]);

        $company = Company::find(1);
        $this->assertSame(25, $company->getCoins());

        $candidate = Candidate::find(1);
        $this->assertTrue($candidate->isHired());

        $notification = Notification::query()
            ->where(Notification::SENDER_USER_ID, 1)
            ->where(Notification::RECEIVER_USER_ID, 2)
            ->where(Notification::TYPE_ID, 2)
            ->first();
        $this->assertNotNull($notification);

        Mail::assertSent(function (NotifyCandidate $mail) use ($notification): bool {
            return 
                $mail->notification->getMessage() === $notification->message
                && $mail->notification->getSubject() === $notification->subject
                && $mail->notification->getSender()->getUserId() === $notification->sender_user_id
                && $mail->notification->getReceiver()->getUserId() === $notification->receiver_user_id;
        });
    }

    public function test_hire_candidate_fails_when_candidated_is_already_hired(): void
    {
        $candidate = Candidate::find(1);
        $candidate->hire();

        $response = $this->patchJson(uri: 'candidates/1/hire');

        $response->assertBadRequest();
        $response->assertExactJson([
            'error' => 'Candidate is already hired!',
        ]);
    }

    public function test_hire_candidate_fails_when_company_hasnt_contacted_candidated_before(): void
    {
        $response = $this->patchJson(uri: 'candidates/1/hire');

        $response->assertBadRequest();
        $response->assertExactJson([
            'error' => 'Employer hasn\'t contacted the Candidate before!',
        ]);
    }
}
