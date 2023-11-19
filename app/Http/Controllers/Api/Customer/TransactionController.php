<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function __invoke()
    {
        $transactions = auth('customer')->user()->transactions()->latest('id')->paginate();

        return TransactionResource::collection($transactions);
    }
}
