<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [

            'id' => $this->id,
            'amount' => $this->amount,
            'customer' => $this->user->name,
            'due_date' => $this->due_date,
            'vat' => $this->vat,
            'is_vat_inclusive' => $this->is_vat_inclusive,
            'status' => $this->status->data(),
            'created_at' => $this->created_at
        ];
    }
}
