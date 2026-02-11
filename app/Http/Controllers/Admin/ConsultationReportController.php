<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationReportController extends Controller
{
    /**
     * Display a listing of all consultations (Admin View).
     */
    public function index(Request $request)
    {
        $query = Consultation::with('user')->orderBy('created_at', 'desc');

        // Search Filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('vehicle_brand', 'like', "%{$search}%")
                  ->orWhere('vehicle_type', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Pagination
        $consultations = $query->paginate(10);

        return view('admin.consultations.index', compact('consultations'));
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ConsultationExport, 'laporan-konsultasi-' . date('Y-m-d') . '.xlsx');
    }
}
