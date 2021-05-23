<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;

/**
 * Policy for checking what user may make.
 */
class MessagePolicy
{
    public const UPDATE = 'update';
    public const DELETE = 'delete';
    
    /**
     * Shows whether given message belongs to user.
     *
     * @param User $user User to check that message belongs to
     * @param Message $message Message to check
     *
     * @return boolean
     */
    protected function belongsTo(User $user, Message $message): bool
    {
        return $message->userId === $user->id;
    }
    
    /**
     * Determine could given user update given message.
     *
     * @param User $user User to validate
     * @param Message $message Message to validate
     *
     * @return boolean
     */
    public function update(User $user, Message $message): bool
    {
        return $this->belongsTo($user, $message);
    }
    
    /**
     * Determine could given user update given message.
     *
     * @param User $user User to validate
     * @param Message $message Message to validate
     *
     * @return boolean
     */
    public function delete(User $user, Message $message): bool
    {
        return $this->belongsTo($user, $message);
    }
}
