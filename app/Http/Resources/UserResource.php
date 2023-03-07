<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"                     => $this->id,
            "name"                   => $this->name,
            "email"                  => $this->email,
            "phone"                  => $this->phone,
            "position"               => $this->positions->pluck('name')[0],
            "position_id"            => $this->positions->pluck('id')[0],
            "registration_timestamp" => strtotime($this->created_at),
            "photo"                  => $this->photo,
        ];
    }


    public static $wrap = 'user';
}
