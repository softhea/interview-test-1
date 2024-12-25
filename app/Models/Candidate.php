<?php

declare(strict_types=1);

namespace App\Models;

use App\Interfaces\CanBeHired;
use App\Interfaces\CanBeNotified;
use App\Notifications\ContactNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property bool $is_hired
 */
class Candidate extends Model implements CanBeNotified, CanBeHired
{
    use HasFactory;

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

    public function isHired(): bool
    {
        return (bool) $this->is_hired;
    }

    public function hire(): void
    {
        $this->is_hired = true;
        $this->save();
    }

    public function hasBeenContactedByUserIdBefore(int $userId): bool
    {
        return $this->receivedNotifications()
            ->where(Notification::SENDER_USER_ID, $userId)
            ->where(Notification::TYPE_ID, operator: ContactNotification::getTypeId())
            ->exists();
    }

    public function receivedNotifications(): HasMany
    {
        return $this->hasMany(
            Notification::class, 
            Notification::RECEIVER_USER_ID, 
            self::USER_ID,
        );
    }
}
