<?php

namespace App\Admin\Http\Requests\Notification;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Notification\MessageType;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Notification\NotificationType;
use App\Enums\VerifiedStatus;
use Illuminate\Validation\Rules\Enum;

class NotificationRequest extends BaseRequest
{
    protected function methodGet(): array
    {
        return [
            'admin_id' => 'required|exists:admins,id',

        ];
    }

    protected function methodPost(): array
    {
        return [
            'title' => ['required', 'string'],
            'message' => ['required'],
            'types' => ['required', new Enum(NotificationType::class)],
            'option' => 'required',
            'driver_id' => ['nullable'],
            'user_id' => ['nullable'],
            'status' => ['required', new Enum(NotificationStatus::class)],
//            'type' => ['required', new Enum(MessageType::class)],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Notification,id'],
            'title' => ['required', 'string'],
            'message' => ['required'],
            'status' => ['required', new Enum(NotificationStatus::class)],
            'is_verified' => ['nullable', new Enum(VerifiedStatus::class)],
            'confirmation_image' => ['nullable'],
            'amount' => ['nullable'],
            'bank_account_number' => ['nullable'],
            'bank_id' => ['nullable','exists:App\Models\Bank,id'],
            'type' => ['required', new Enum(MessageType::class)],

        ];
    }

    protected function methodPatch(): array
    {
        return [
            'admin_id' => 'required|exists:admins,id',
        ];
    }
}
