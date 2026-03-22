<?php

namespace App\Enums\Role;


use App\Admin\Support\Enum;

enum Role: string
{
    use Enum;

    case Customer = "customer";

    case Driver = "driver";
    case SupperAdmin = "superAdmin";
    case VehicleOwner = "vehicle_owner";

    public function badge(): string
    {
        return match ($this) {
            Role::Customer => 'bg-green-lt',
            Role::Driver => 'bg-red-lt',
            Role::SupperAdmin => 'bg-pink-lt',
            Role::VehicleOwner => 'bg-yellow-lt'
        };
    }
}
