<?php

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * Message resource.
 */
class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            Message::ID => $this->id,
            Message::MESSAGE =>$this->message,
            Message::USER_ID => $this->userId,
            Message::CREATED_AT => $this->createdAt,
            Message::UPDATED_AT => $this->updatedAt,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
