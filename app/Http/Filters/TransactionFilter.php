<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TransactionFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'amount',
        'user_id',
        'status',
        'range_date',
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return Builder
     */
    protected function amount($value)
    {
        if ($value) {
            return $this->builder->where('name', $value);
        }

        return $this->builder;
    }

    protected function userId($value)
    {
        if ($value) {
            return $this->builder->where('user_id', $value);
        }

        return $this->builder;
    }

    /**
     * Sorting results by the given id.
     *
     * @return Builder
     */
    public function status($value)
    {
        if ($value) {
            $this->builder->where('status', $value);
        }

        return $this->builder;
    }

    public function rangeDate()
    {
        return $this->builder->select([
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(CASE WHEN status = "paid" then amount ELSE 0 END) AS paid'),
            DB::raw('SUM(CASE WHEN status = "outstanding" then amount ELSE 0 END) AS outstanding'),
            DB::raw('SUM(CASE WHEN status = "overdue" then amount ELSE 0 END) AS overdue'),
           // DB::raw('SUM(IF(status = "outstanding", amount, 0)) as outstanding'),
            //DB::raw('SUM(IF(status = "overdue", amount, 0)) as overdue'),
        ])
            ->whereBetween('created_at', [$this->request->start_date, $this->request->end_date])
            ->groupBy('year', 'month');

    }
}
