<?php

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileMessageResource extends JsonResource
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
            'userFullName' => $this->user->firstName . ' ' . $this->user->lastName
        ];
    }
}
