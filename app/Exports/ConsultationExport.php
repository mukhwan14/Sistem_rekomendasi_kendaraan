<?php

namespace App\Exports;

use App\Models\Consultation;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ConsultationExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        return Consultation::query()->with('user')->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal Konsultasi',
            'Nama User',
            'Email User',
            'Jenis Kendaraan',
            'Merk & Tipe',
            'Tahun',
            'Rekomendasi Servis',
            'Status',
        ];
    }

    public function map($consultation): array
    {
        return [
            $consultation->id,
            $consultation->created_at->format('d-m-Y H:i'),
            $consultation->user->name ?? 'Deleted User',
            $consultation->user->email ?? '-',
            $consultation->vehicle_type,
            $consultation->vehicle_brand,
            $consultation->vehicle_year,
            $consultation->result_recommendation ?: 'Tidak ada rekomendasi khusus (Kondisi Aman)',
            'Selesai',
        ];
    }
}
