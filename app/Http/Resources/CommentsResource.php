<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tid' => $this->tid,
            'message' => $this->message,
            'time' => $this->created_at,
            'action' => auth('sanctum')->check() ? auth('sanctum')->user()->id == $this->uid ? true : false : false,
            'user' => UsersResource::make($this->users),
        ];
    }
}
