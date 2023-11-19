<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $payments = Payment::query()->latest('id')->paginate();

        return PaymentResource::collection($payments);
    }

    public function store(PaymentRequest $request): JsonResource
    {
        $payment = Payment::create($request->validated());

        $payment->transaction->setStatusAcordingToAmount();

        return new PaymentResource($payment);
    }

    public function show(Payment $payment): JsonResource
    {
        return new PaymentResource($payment);
    }

    public function update(PaymentRequest $request, Payment $payment): JsonResource
    {
        $payment->update($request->validated());

        $payment->transaction->setStatusAcordingToAmount();

        return new PaymentResource($payment);
    }

    public function destroy(Payment $payment): Response
    {
        $payment->delete();

        $payment->transaction->setStatusAcordingToAmount();

        return response()->noContent();
    }
}
