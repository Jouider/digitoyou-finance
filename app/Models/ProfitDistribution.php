<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfitDistribution extends Model
{
    protected $fillable = [
        'project_id',
        'total_profit',
        'agency_share',
        'sadaqah_share',
        'abdellah_share',
        'mouad_share',
        'agency_percentage',
        'sadaqah_percentage',
        'distribution_date',
        'notes'
    ];

    protected $casts = [
        'total_profit' => 'decimal:2',
        'agency_share' => 'decimal:2',
        'sadaqah_share' => 'decimal:2',
        'abdellah_share' => 'decimal:2',
        'mouad_share' => 'decimal:2',
        'agency_percentage' => 'decimal:2',
        'sadaqah_percentage' => 'decimal:2',
        'distribution_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Calcul automatique des parts
     */
    public static function calculateShares(float $totalProfit, float $agencyPercentage = 10.00, float $sadaqahPercentage = 2.50): array
    {
        $agencyShare = ($totalProfit * $agencyPercentage) / 100;
        $sadaqahShare = ($totalProfit * $sadaqahPercentage) / 100;
        $remainingProfit = $totalProfit - $agencyShare - $sadaqahShare;
        
        // 50-50 entre Abdellah et Mouad
        $abdellahShare = $remainingProfit / 2;
        $mouadShare = $remainingProfit / 2;

        return [
            'agency_share' => round($agencyShare, 2),
            'sadaqah_share' => round($sadaqahShare, 2),
            'abdellah_share' => round($abdellahShare, 2),
            'mouad_share' => round($mouadShare, 2),
        ];
    }
}
