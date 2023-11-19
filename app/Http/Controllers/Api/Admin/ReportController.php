<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReportRequest;
use App\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;


class ReportController extends Controller
{
    public function transactions(ReportRequest $request) : JsonResource
    {
        $transactions = Transaction::filter()->get();

        return JsonResource::collection($transactions);
    }
}
