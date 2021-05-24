<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

/**
 * Message collection resource.
 */
class MessageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => MessageResource::collection($this->collection),
        ];
    }
}
