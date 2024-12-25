<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\NotifyCandidate;
use App\Models\Company;
use App\Models\Notification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactCandidateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_candidate_has_been_contacted(): void
    {
        Mail::fake();

        $response = $this->patchJson(uri: 'candidates/1/contact');

        $response->assertOk();
        $response->assertExactJson([
            'message' => 'Candidate has been contacted',
            'coins' => 15,
        ]);

        $company = Company::find(1);

        $this->assertSame(15, $company->getCoins());

        $contactNotification = $company->getLatestContactNotificationToUserId(2);

        $this->assertNotNull(actual: $contactNotification->toArray());
        
        Mail::assertSent(function (NotifyCandidate $mail) use ($contactNotification) {
            return 
                $mail->notification->getMessage() === $contactNotification->message
                && $mail->notification->getSubject() === $contactNotification->subject
                && $mail->notification->getSender()->getUserId() === $contactNotification->sender_user_id
                && $mail->notification->getReceiver()->getUserId() === $contactNotification->receiver_user_id;
        });
    }

    public function test_contact_candidate_fails_when_company_doesnt_have_enough_coins(): void
    {
        $company = Company::find(1);
        $company->addCoins(-16);

        $response = $this->patchJson(uri: 'candidates/1/contact');

        $response->assertBadRequest();
        $response->assertExactJson([
            'error' => 'To be able to contact candidate you need 5 coins and you only have 4!',
        ]);
    }
}
