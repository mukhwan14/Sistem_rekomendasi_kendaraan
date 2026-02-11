<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiagnosisQuestion;
use Illuminate\Http\Request;

class DiagnosisQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = DiagnosisQuestion::orderBy('order')->get();
        return view('admin.diagnosis_questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get existing variables from Rules to suggest to user
        $existingVariables = \App\Models\RuleCondition::distinct()->pluck('fact_variable');
        return view('admin.diagnosis_questions.create', compact('existingVariables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:diagnosis_questions,code',
            'question' => 'required|string',
            'type' => 'required|in:select,number,boolean',
            'options' => 'nullable|string', // JSON string from form
            'order' => 'integer',
        ]);

        // Decode JSON options if present (from simple textarea or dynamic input)
        // For simplicity, we'll assume admin inputs valid JSON or use a helper to format it
        if ($request->filled('options')) {
            $validated['options'] = json_decode($request->options, true);
        }

        DiagnosisQuestion::create($validated);

        return redirect()->route('admin.diagnosis_questions.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DiagnosisQuestion $diagnosisQuestion)
    {
        return view('admin.diagnosis_questions.edit', compact('diagnosisQuestion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DiagnosisQuestion $diagnosisQuestion)
    {
        $validated = $request->validate([
            'code' => 'required|unique:diagnosis_questions,code,' . $diagnosisQuestion->id,
            'question' => 'required|string',
            'type' => 'required|in:select,number,boolean',
            'options' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('options')) {
            $validated['options'] = json_decode($request->options, true);
        } else {
            $validated['options'] = null;
        }
        
        // Checkbox handling
        $validated['is_active'] = $request->has('is_active');

        $diagnosisQuestion->update($validated);

        return redirect()->route('admin.diagnosis_questions.index')->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiagnosisQuestion $diagnosisQuestion)
    {
        $diagnosisQuestion->delete();
        return redirect()->route('admin.diagnosis_questions.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
