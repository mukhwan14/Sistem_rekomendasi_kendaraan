<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rules = \App\Models\Rule::orderBy('priority', 'desc')->get();
        return view('admin.rules.index', compact('rules'));
    }

    public function create()
    {
        return view('admin.rules.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:rules,code',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'recommendation' => 'required|string',
            'action_list' => 'required|string',
            'priority' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        // Convert action list string to array of actions, handling Windows and Linux newline properly
        $actionList = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $validated['action_list']))));
        $validated['action_list'] = $actionList;

        \App\Models\Rule::create($validated);

        return redirect()->route('admin.rules.index')->with('success', 'Rule berhasil ditambahkan.');
    }





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rule = \App\Models\Rule::findOrFail($id);
        return view('admin.rules.edit', compact('rule'));
    }

    public function update(Request $request, string $id)
    {
        $rule = \App\Models\Rule::findOrFail($id);
        
        $validated = $request->validate([
            'code' => 'required|unique:rules,code,'.$rule->id,
            'name' => 'required|string',
            'description' => 'nullable|string',
            'recommendation' => 'required|string',
            'action_list' => 'required|string',
            'priority' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        // Handle checkbox unregulated value
        $validated['is_active'] = $request->has('is_active');

        // Convert action list string to array of actions, handling Windows and Linux newline properly
        $actionList = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $validated['action_list']))));
        $validated['action_list'] = $actionList;

        $rule->update($validated);

        return redirect()->route('admin.rules.index')->with('success', 'Rule berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rule = \App\Models\Rule::findOrFail($id);
        $rule->delete();

        return redirect()->route('admin.rules.index')->with('success', 'Rule berhasil dihapus.');
    }
}
