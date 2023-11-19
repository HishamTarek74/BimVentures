<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $transactions = Transaction::query()
            ->with('user')
            ->latest('id')
            ->paginate();

        return TransactionResource::collection($transactions);
    }

    public function store(TransactionRequest $request): JsonResource
    {
        $transaction = Transaction::create($request->validated());

        $transaction->setStatusAcordingToAmount();

        return new TransactionResource($transaction);
    }

    public function show(Transaction $transaction): JsonResource
    {
        $transaction->load('user');

        return new TransactionResource($transaction);

    }

    public function update(TransactionRequest $request, Transaction $transaction): JsonResource
    {
       // dd($transaction->payments()->sum('amount'));
        $transaction->update($request->validated());

        $transaction->setStatusAcordingToAmount();

        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction): Response
    {
        $transaction->delete();

        return response()->noContent();
    }
}
