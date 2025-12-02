<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundMovement extends Model
{
    protected $fillable = [
        'person',
        'type',
        'amount',
        'description',
        'project_payment_id',
        'expense_id',
        'profit_distribution_id',
        'movement_date',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'movement_date' => 'date'
    ];

    // Relationships
    public function projectPayment()
    {
        return $this->belongsTo(ProjectPayment::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function profitDistribution()
    {
        return $this->belongsTo(ProfitDistribution::class);
    }

    // Helper methods
    public static function getBalance($person)
    {
        $entrees = self::where('person', $person)
            ->whereIn('type', ['entree', 'distribution'])
            ->sum('amount');
        
        $sorties = self::where('person', $person)
            ->whereIn('type', ['sortie', 'versement_agence'])
            ->sum('amount');
        
        return $entrees - $sorties;
    }

    public static function getAllBalances()
    {
        return [
            'abdellah' => self::getBalance('abdellah'),
            'mouad' => self::getBalance('mouad'),
            'agency' => self::getBalance('agency')
        ];
    }
}
