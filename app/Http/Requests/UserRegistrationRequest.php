<?php

namespace App\Http\Requests;

/**
 * Request for user registration.
 *
 * @property string $firstName User first name
 * @property string $lastName User last name
 */
class UserRegistrationRequest extends LoginRequest
{
    public const FIRST_NAME = 'firstName';
    public const LAST_NAME = 'lastName';
    
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        $rules = [
            self::FIRST_NAME => ['required', 'string'],
            self::LAST_NAME => ['required', 'string'],
        ];
        
        return array_merge(parent::rules(), $rules);
    }
}
