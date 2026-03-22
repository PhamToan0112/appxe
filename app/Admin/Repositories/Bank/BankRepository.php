<?php

namespace App\Admin\Repositories\Bank;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Bank;

class BankRepository extends EloquentRepository implements BankRepositoryInterface
{

    public function getModel(): string
    {
        return Bank::class;
    }


}
