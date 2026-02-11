<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'recommendation',
        'action_list',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'action_list' => 'array',
        'is_active' => 'boolean',
    ];

    public function conditions()
    {
        return $this->hasMany(RuleCondition::class);
    }
}
