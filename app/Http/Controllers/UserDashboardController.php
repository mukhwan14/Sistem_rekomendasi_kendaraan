<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\DailyEarning;
use App\Models\Service;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // ── Summary Stats ─────────────────────────────────────────────────────
        $allActive = DailyEarning::where('user_id', $userId)
            ->where('status', 'active')->get();

        $totalSavings   = $allActive->sum('allocated_funds');
        $totalDays      = $allActive->count();
        $totalEarnings  = $allActive->sum('income');

        $latestRecommendation = Service::where('cost', '<=', $totalSavings)
            ->orderBy('cost', 'desc')->first();

        // ── Daily Chart (last 14 days) ─────────────────────────────────────────
        $last14 = collect(range(13, 0))->map(fn($i) => Carbon::today()->subDays($i));

        $dailyLabels = $last14->map(fn($d) => $d->format('d M'))->values();
        $dailyIncome = $last14->map(function ($d) use ($userId) {
            return (float) DailyEarning::where('user_id', $userId)
                ->whereDate('date', $d)->sum('income');
        })->values();
        $dailySavings = $last14->map(function ($d) use ($userId) {
            return (float) DailyEarning::where('user_id', $userId)
                ->whereDate('date', $d)->sum('allocated_funds');
        })->values();

        // ── Monthly Chart (last 6 months) ──────────────────────────────────────
        $last6Months = collect(range(5, 0))->map(fn($i) => Carbon::today()->startOfMonth()->subMonths($i));

        $monthlyLabels  = $last6Months->map(fn($m) => $m->translatedFormat('M Y'))->values();
        $monthlyIncome  = $last6Months->map(function ($m) use ($userId) {
            return (float) DailyEarning::where('user_id', $userId)
                ->whereYear('date', $m->year)
                ->whereMonth('date', $m->month)
                ->sum('income');
        })->values();
        $monthlySavings = $last6Months->map(function ($m) use ($userId) {
            return (float) DailyEarning::where('user_id', $userId)
                ->whereYear('date', $m->year)
                ->whereMonth('date', $m->month)
                ->sum('allocated_funds');
        })->values();

        return view('user.dashboard', compact(
            'totalSavings', 'totalDays', 'totalEarnings', 'latestRecommendation',
            'dailyLabels', 'dailyIncome', 'dailySavings',
            'monthlyLabels', 'monthlyIncome', 'monthlySavings'
        ));
    }
}
