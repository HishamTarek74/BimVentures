<?php

namespace App\Enums;

enum TransactionStatus : string
{
    case Paid = 'paid';
    case Outstanding = 'outstanding';
    case Overdue = 'overdue';

    public function data(): array
    {
        return match ($this) {
            self::Paid => [
                'code' => self::Paid->value,
                'name' => 'Paid',
                'icon' => 'sym_r_live_tv',
                'color' => 'grey',
            ],

            self::Outstanding => [
                'code' => self::Outstanding->value,
                'name' => 'Outstanding',
                'icon' => 'sym_r_live_tv',
                'color' => 'green',
            ],

            self::Overdue => [
                'code' => self::Overdue->value,
                'name' => 'Overdue',
                'icon' => 'sym_r_live_tv',
                'color' => 'red',
            ],

        };
    }
}
