<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request for create or update message.
 *
 * @property string $message Text message
 */
class MessageRequest extends FormRequest
{
    public const MESSAGE = 'message';
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            self::MESSAGE => ['required', 'string'],
        ];
    }
    
}
