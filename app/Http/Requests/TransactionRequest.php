<?php

namespace App\Http\Requests;

use App\Enums\TransactionStatus;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer',Rule::exists(User::class, 'id')],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'vat' => ['required', 'between:0,100'],
            'is_vat_inclusive' => ['required', 'boolean'],
            // 'status' => ['required', Rule::enum(TransactionStatus::class)],
        ];
    }
}
