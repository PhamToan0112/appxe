<?php

namespace App\Admin\Services\Wallet;
use Illuminate\Http\Request;

interface WalletServiceInterface
{
    public function deposit(Request $request);
    public function withdraw(Request $request);

    public function getBalance(Request $request);


}
