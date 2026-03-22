<?php

namespace App\Api\V1\Http\Resources\Auth;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     * @throws Exception
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $roles = $this->roles->pluck('name');
        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'slug' => $this->slug,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'gender' => $this->gender,
            'active' => $this->active,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'area_id' => $this->area_id,
            'birthday' => $this->birthday,
            'avatar' => formatImageUrl($this->avatar),
            'notification_preference' => $this->notification_preference,
            'bank_id' => $this->bank_id,
            'bank_account_number' => $this->bank_account_number,
            'status' => $this->status,
            'created_at' => format_date($this->created_at),
            'roles' => $roles
        ];
    }
}
