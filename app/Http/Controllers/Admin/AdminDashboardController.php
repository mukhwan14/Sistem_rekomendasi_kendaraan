<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DailyEarning;
use App\Models\Service;
use App\Models\Consultation;
use App\Models\Rule;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── Summary Stats ──────────────────────────────────────────────────────
        $totalUsers         = User::count();
        $totalConsultations = Consultation::count();
        $totalRules         = Rule::where('is_active', true)->count();
        $totalServices      = Service::count();

        // Total dana yang sudah terkumpul semua user
        $totalFundsAllUsers = DailyEarning::where('status', 'active')->sum('allocated_funds');
        // Total setoran hari ini
        $todayEarnings      = DailyEarning::whereDate('date', today())->count();

        // ── Driver Setoran Chart (last 14 days) ────────────────────────────────
        $last14 = collect(range(13, 0))->map(fn($i) => Carbon::today()->subDays($i));

        $dailyLabels = $last14->map(fn($d) => $d->format('d M'))->values();
        $dailyTotal  = $last14->map(function ($d) {
            return (float) DailyEarning::whereDate('date', $d)->sum('income');
        })->values();
        $dailySaved  = $last14->map(function ($d) {
            return (float) DailyEarning::whereDate('date', $d)->sum('allocated_funds');
        })->values();

        // ── Monthly Chart (last 6 months) ──────────────────────────────────────
        $last6 = collect(range(5, 0))->map(fn($i) => Carbon::today()->startOfMonth()->subMonths($i));

        $monthlyLabels = $last6->map(fn($m) => $m->translatedFormat('M Y'))->values();
        $monthlyIncome = $last6->map(function ($m) {
            return (float) DailyEarning::whereYear('date', $m->year)->whereMonth('date', $m->month)->sum('income');
        })->values();
        $monthlySaved = $last6->map(function ($m) {
            return (float) DailyEarning::whereYear('date', $m->year)->whereMonth('date', $m->month)->sum('allocated_funds');
        })->values();

        // ── Recent Consultations ───────────────────────────────────────────────
        $recentConsultations = Consultation::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalConsultations', 'totalRules', 'totalServices',
            'totalFundsAllUsers', 'todayEarnings',
            'dailyLabels', 'dailyTotal', 'dailySaved',
            'monthlyLabels', 'monthlyIncome', 'monthlySaved',
            'recentConsultations'
        ));
    }
}
