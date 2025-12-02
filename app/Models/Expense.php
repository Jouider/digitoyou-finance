<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'amount',
        'frequency',
        'expense_date',
        'next_expense_date',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
        'next_expense_date' => 'date',
    ];
}
