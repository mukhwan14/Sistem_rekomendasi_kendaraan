<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyEarning extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'income',
        'vehicle_condition',
        'allocation_percentage',
        'allocated_funds',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'income' => 'decimal:2',
        'allocated_funds' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
