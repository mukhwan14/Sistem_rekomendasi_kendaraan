<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RuleConditionController extends Controller
{
    public function create(Request $request)
    {
        $rule_id = $request->query('rule_id');
        $rule = \App\Models\Rule::findOrFail($rule_id);
        
        // Pass the full objects to build a proper select dropdown dynamically
        $variables = \App\Models\DiagnosisQuestion::orderBy('order')->get(['code', 'question', 'type', 'options']);
        
        return view('admin.rule_conditions.create', compact('rule', 'variables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rule_id' => 'required|exists:rules,id',
            'fact_variable' => 'required|string',
            'operator' => 'required|in:>,<,>=,<=,==,!=',
            'value' => 'required|string',
            'value_type' => 'required|in:string,numeric,boolean',
        ]);

        \App\Models\RuleCondition::create($validated);

        return redirect()->route('admin.rules.edit', $validated['rule_id'])->with('success', 'Kondisi berhasil ditambahkan.');
    }

    public function destroy(string $id)
    {
        $condition = \App\Models\RuleCondition::findOrFail($id);
        $rule_id = $condition->rule_id;
        $condition->delete();

        return redirect()->route('admin.rules.edit', $rule_id)->with('success', 'Kondisi berhasil dihapus.');
    }
}
