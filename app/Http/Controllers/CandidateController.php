<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Company;
use App\Notifications\ContactNotification;
use App\Services\HiringService;
use App\Services\NotificationService;
use Exception;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class CandidateController extends Controller
{
    public function index(): View
    {
        /**
         * @var Candidate[]
         */
        $candidates = Candidate::query()
        ->with('receivedNotifications')
        ->get();

        /** @var Company $company */
        $company = Company::with(relations: 'wallet')
            ->where(Company::USER_ID, operator: Company::LOGGED_USER_ID)->first();
        $coins = $company?->getCoins();

        $softSkills = [];
        foreach ($candidates as $candidate) {
            $candidate->can_be_hired = 
                !$candidate->isHired() 
                && $candidate->hasBeenContactedByUserIdBefore($company->getUserId());
            foreach ((array) json_decode($candidate->soft_skills) as $softSkill) {
                $softSkills[] = $softSkill;
            }
        }   
        $softSkills = array_unique($softSkills);
        shuffle($softSkills);
        $desiredSoftSkills = array_slice($softSkills, 0, 2);

        return view(
            'candidates.index', 
            compact(
                'candidates', 
                'coins',
                'desiredSoftSkills'
            )
        );
    }

    public function contact(Candidate $candidate, NotificationService $notificationService): JsonResponse
    {
        /** @var Company $company */
        $company = Company::with(relations: 'wallet')
            ->where(Company::USER_ID, operator: Company::LOGGED_USER_ID)->first();
            
        try {
            $notificationService->notify(
                new ContactNotification($company, $candidate)
            );
        } catch (Exception $exception) {
            return new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                ], 
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse([
            'message' => 'Candidate has been contacted',
            'coins' => $company->refresh()->getCoins(),
        ]);
    }

    public function hire(Candidate $candidate, HiringService $hiringServicee)
    {
        /** @var Company $company */
        $company = Company::with(relations: 'wallet')
            ->where(Company::USER_ID, operator: Company::LOGGED_USER_ID)->first();

        try {
            $hiringServicee->hire($company, $candidate);
        } catch (Exception $exception) {
            return new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                ], 
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse([
            'message' => 'Candidate has been hired',
            'coins' => $company->refresh()->getCoins(),
        ]);
    }
}
