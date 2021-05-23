<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Models\User;

/**
 * User resource.
 */
class UserResource extends JsonResource
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
            User::ID => $this->id,
            User::FIRST_NAME => $this->firstName,
            User::LAST_NAME => $this->lastName,
        ];
    }
}
