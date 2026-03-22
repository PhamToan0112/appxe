<?php

namespace App\Admin\Repositories\Wallet;

use App\Admin\Repositories\EloquentRepository;
use App\Enums\Vehicle\VehicleStatus;
use App\Models\Wallet;

class WalletRepository extends EloquentRepository implements WalletRepositoryInterface
{


    public function getModel(): string
    {
        return Wallet::class;
    }


}
