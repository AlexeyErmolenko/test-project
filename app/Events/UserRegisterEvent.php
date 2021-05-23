<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * User register event.
 */
class UserRegisterEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * User object.
     *
     * @var User
     */
    protected $user;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    /**
     * Get user object.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
