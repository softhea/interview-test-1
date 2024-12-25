<?php

declare(strict_types=1);

namespace App\Models;

use App\Interfaces\CanHire;
use App\Interfaces\CanNotify;
use App\Interfaces\CanPay;
use App\Notifications\ContactNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model implements CanNotify, CanPay, CanHire
{
    use HasFactory;

    public const LOGGED_USER_ID = 1;

    public const USER_ID = 'user_id';
    
    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCoins(): int
    {
        return $this->wallet->coins;
    }

    public function addCoins(int $noOfCoins): void
    {
        $this->wallet()->update(['coins' => $this->getCoins() + $noOfCoins]);
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, Wallet::USER_ID, self::USER_ID);
    }

    public function sentNotifications(): HasMany
    {
        return $this->hasMany(
            Notification::class, 
            Notification::SENDER_USER_ID, 
            self::USER_ID
        );
    }

    public function hasContactedUserIdBefore(int $userId): bool
    {
        return $this->sentNotifications()
            ->where(Notification::RECEIVER_USER_ID, $userId)
            ->where(Notification::TYPE_ID, ContactNotification::getTypeId())
            ->exists();
    }

    public function getLatestContactNotificationToUserId(int $userId): ?Notification
    {
        return $this->sentNotifications()
            ->where(Notification::RECEIVER_USER_ID, $userId)
            ->where(Notification::TYPE_ID, ContactNotification::getTypeId())
            ->latest()
            ->first();
    }
}
