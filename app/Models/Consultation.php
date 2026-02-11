<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_type',
        'vehicle_brand',
        'vehicle_year',
        'consultation_date',
        'input_facts',
        'result_recommendation',
        'matched_rules',
    ];

    protected $casts = [
        'input_facts' => 'array',
        'matched_rules' => 'array',
        'consultation_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
