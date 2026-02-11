<?php

namespace App\Services;

use App\Models\Rule;
use Illuminate\Support\Collection;

class ForwardChainingService
{
    /**
     * Process input facts against active rules.
     *
     * @param array $userFacts Key-value pair of user inputs (e.g., ['income' => 6000000, 'oil' => 'bad'])
     * @return array Result containing matched rules and aggregated recommendations
     */
    public function analyze(array $userFacts): array
    {
        // 1. Fetch all active rules, ordered by priority (highest first)
        $rules = Rule::where('is_active', true)
            ->with('conditions')
            ->orderBy('priority', 'desc')
            ->get();

        $matchedRules = [];
        $recommendations = [];

        // 2. Iterate through each rule
        foreach ($rules as $rule) {
            if ($this->evaluateRule($rule, $userFacts)) {
                $matchedRules[] = $rule; 
                $recommendations[] = $rule->recommendation;
            }
        }

        return [
            'matched_rules' => $matchedRules,
            'recommendations' => array_unique($recommendations),
        ];
    }

    /**
     * Evaluate if a rule matches the given facts.
     */
    private function evaluateRule(Rule $rule, array $facts): bool
    {
        // If rule has no conditions, it might be a default rule (optional logic)
        if ($rule->conditions->isEmpty()) {
            return false; 
        }

        foreach ($rule->conditions as $condition) {
            $variable = $condition->fact_variable;
            
            // Check if fact exists in user input
            if (!isset($facts[$variable])) {
                return false; // Fact missing, rule cannot be evaluated
            }

            $userValue = $facts[$variable];
            $conditionValue = $this->castValue($condition->value, $condition->value_type);
            $operator = $condition->operator;

            if (!$this->compare($userValue, $operator, $conditionValue)) {
                return false; // One condition failed
            }
        }

        return true; // All conditions passed
    }

    /**
     * Compare two values based on operator.
     */
    private function compare($userValue, $operator, $conditionValue): bool
    {
        switch ($operator) {
            case '>': return $userValue > $conditionValue;
            case '<': return $userValue < $conditionValue;
            case '>=': return $userValue >= $conditionValue;
            case '<=': return $userValue <= $conditionValue;
            case '==': return $userValue == $conditionValue;
            case '!=': return $userValue != $conditionValue;
            default: return false;
        }
    }

    /**
     * Cast value string to appropriate type.
     */
    private function castValue($value, $type)
    {
        switch ($type) {
            case 'numeric': return is_numeric($value) ? (float)$value : 0;
            case 'boolean': return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            default: return (string)$value;
        }
    }
}
