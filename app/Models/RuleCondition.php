<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleCondition extends Model
{
    protected $fillable = [
        'rule_id',
        'fact_variable',
        'operator',
        'value',
        'value_type',
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }
}
