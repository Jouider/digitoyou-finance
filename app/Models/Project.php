<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'description',
        'url',
        'price',
        'status',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function profitDistributions(): HasMany
    {
        return $this->hasMany(ProfitDistribution::class);
    }

    public function projectPayments(): HasMany
    {
        return $this->hasMany(ProjectPayment::class);
    }

    /**
     * Calcul du montant total payé par le client
     */
    public function getTotalPaidAttribute(): float
    {
        return $this->projectPayments()->sum('amount');
    }

    /**
     * Calcul du reste à payer
     */
    public function getRemainingAmountAttribute(): float
    {
        return $this->price - $this->total_paid;
    }

    /**
     * Pourcentage payé
     */
    public function getPaymentPercentageAttribute(): float
    {
        if ($this->price == 0) return 0;
        return ($this->total_paid / $this->price) * 100;
    }
}
