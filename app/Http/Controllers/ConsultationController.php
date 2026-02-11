<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function create()
    {
        $questions = \App\Models\DiagnosisQuestion::where('is_active', true)->orderBy('order')->get();
        return view('consultation.create', compact('questions'));
    }

    public function store(\Illuminate\Http\Request $request, \App\Services\ForwardChainingService $inferenceEngine)
    {
        // 1. Validate Input
        $validated = $request->validate([
            'vehicle_type' => 'required|string',
            'vehicle_brand' => 'required|string',
            'vehicle_year' => 'required|integer',
            // Flexible facts input
            'facts' => 'required|array',
        ]);

        // 2. Process Inference
        $inputFacts = $validated['facts'];
        // Ensure numeric values are cast correctly if coming from form as string
        foreach ($inputFacts as $key => $value) {
            if (is_numeric($value)) {
                $inputFacts[$key] = (float)$value;
            }
        }

        $result = $inferenceEngine->analyze($inputFacts);

        // 3. Save to Database
        $consultation = \App\Models\Consultation::create([
            'user_id' => auth()->id(),
            'vehicle_type' => $validated['vehicle_type'],
            'vehicle_brand' => $validated['vehicle_brand'],
            'vehicle_year' => $validated['vehicle_year'],
            'consultation_date' => now(),
            'input_facts' => $inputFacts,
            'result_recommendation' => implode("\n", $result['recommendations']),
            'matched_rules' => collect($result['matched_rules'])->pluck('code')->toArray(),
        ]);

        // 4. Return Result
        return redirect()->route('consultation.show', $consultation->id);
    }

    public function show($id)
    {
        $consultation = \App\Models\Consultation::with('user')->findOrFail($id);
        
        // Fetch full Rule objects with conditions for "Explainable AI"
        $rules = \App\Models\Rule::with('conditions')
                    ->whereIn('code', $consultation->matched_rules ?? [])
                    ->get();

        return view('consultation.show', compact('consultation', 'rules'));
    }

    public function index()
    {
        $consultations = \App\Models\Consultation::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('consultation.index', compact('consultations'));
    }

    public function exportPdf($id)
    {
        $consultation = \App\Models\Consultation::with('user')->findOrFail($id);
        
        // Ensure user owns the consultation or is admin
        if (auth()->id() !== $consultation->user_id && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('consultation.pdf', compact('consultation'));
        return $pdf->download('laporan-konsultasi-' . $consultation->id . '.pdf');
    }
}
