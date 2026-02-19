<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DailyEarningController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // 1. Get History (Show ALL for history log, but mark status)
        $earnings = \App\Models\DailyEarning::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->get();
            
        // 2. Calculate Total Funds (ONLY ACTIVE)
        $totalFunds = $earnings->where('status', 'active')->sum('allocated_funds');
        
        // 3. Get Recommendation (Services attainable with current funds)
        $recommendedServices = \App\Models\Service::where('cost', '<=', $totalFunds)
            ->orderBy('cost', 'desc')
            ->get();
            
        // 4. Get ALL Services (to show progress)
        $allServices = \App\Models\Service::orderBy('cost')->get();

        return view('daily_earnings.index', compact('earnings', 'totalFunds', 'recommendedServices', 'allServices'));
    }

    public function create()
    {
        return view('daily_earnings.create');
    }

    public function resetHistory()
    {
        \App\Models\DailyEarning::where('user_id', auth()->id())
            ->where('status', 'active')
            ->update(['status' => 'used']);

        return redirect()->route('daily_earnings.index')->with('success', 'Riwayat tabungan berhasil di-reset (dana digunakan). Mulai menabung dari nol lagi!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => [
                'required',
                'date',
                 \Illuminate\Validation\Rule::unique('daily_earnings')->where(function ($query) {
                     return $query->where('user_id', auth()->id());
                 }),
            ],
            'income' => 'required|numeric|min:0',
        ], [
            'date.unique' => 'Anda sudah memasukkan data untuk tanggal ini.',
        ]);

        $income = $validated['income'];
        $condition = 'layak'; // Default as input is removed
        $percentage = 0;

        // Forward Chaining Logic (Rules 1-4)
        // Rule 1: <= 150k AND Layak -> 5%
        if ($income <= 150000 && $condition === 'layak') {
            $percentage = 5;
        }
        // Rule 4: <= 150k AND Butuh Perawatan -> 8%
        elseif ($income <= 150000 && $condition === 'butuh_perawatan') {
            $percentage = 8;
        }
        // Rule 2: > 150k AND <= 300k -> 10% (Condition ignored in rule description but implied usually 'any', or strictly defined. Assuming applies to both or default logic)
        // Based on user request: "Rule 2 IF pendapatan harian > Rp150.000 AND <= Rp300.000 THEN ... = 10%"
        elseif ($income > 150000 && $income <= 300000) {
            $percentage = 10;
        }
        // Rule 3: > 300k -> 15%
        elseif ($income > 300000) {
            $percentage = 15;
        }
        
        // Fallback or specific edge cases can be added here
        
        $allocatedFunds = $income * ($percentage / 100);

        \App\Models\DailyEarning::create([
            'user_id' => auth()->id(),
            'date' => $validated['date'],
            'income' => $income,
            'vehicle_condition' => $condition,
            'allocation_percentage' => $percentage,
            'allocated_funds' => $allocatedFunds,
        ]);

        return redirect()->route('daily_earnings.index')->with('success', 'Data harian berhasil disimpan. Dana servis bertambah Rp ' . number_format($allocatedFunds, 0, ',', '.'));
    }
}
