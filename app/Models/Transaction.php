<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Http\Filters\Filterable;
use App\Http\Filters\TransactionFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory , Filterable;

    protected $fillable = [
        'user_id',
        'amount',
        'due_date',
        'vat',
        'is_vat_inclusive',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_vat_inclusive' => 'boolean',
        'status' => TransactionStatus::class,
    ];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = TransactionFilter::class;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function setStatusAcordingToAmount(): void
    {

        $status = ($this->payments()->sum('amount') <= $this->amount)
            ? TransactionStatus::Paid
            : (now()->gt($this->due_date) ? TransactionStatus::Overdue : TransactionStatus::Outstanding);

        $this->update(['status' => $status]);
    }
}
