<!DOCTYPE html>
<html>
<head>
    <title>Laporan Konsultasi Servis</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .details { margin-bottom: 20px; }
        .details table { width: 100%; border-collapse: collapse; }
        .details th, .details td { text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
        .recommendation { background-color: #f9f9f9; padding: 15px; border-left: 5px solid #007bff; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Hasil Konsultasi Servis</h1>
        <p>Tanggal: {{ $consultation->created_at->format('d F Y H:i') }}</p>
    </div>

    <div class="details">
        <h3>Data Pelanggan & Kendaraan</h3>
        <table>
            <tr>
                <th>Nama Pelanggan</th>
                <td>{{ $consultation->user->name }}</td>
            </tr>
            <tr>
                <th>Jenis Kendaraan</th>
                <td>{{ $consultation->vehicle_type }}</td>
            </tr>
            <tr>
                <th>Merk / Tipe</th>
                <td>{{ $consultation->vehicle_brand }}</td>
            </tr>
            <tr>
                <th>Tahun Pembuatan</th>
                <td>{{ $consultation->vehicle_year }}</td>
            </tr>
        </table>
    </div>

    <div class="details">
        <h3>Input Kondisi</h3>
        <table>
            @foreach($consultation->input_facts as $key => $value)
            <tr>
                <th>{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                <td>
                    @if(is_numeric($value))
                        {{ number_format($value, 0, ',', '.') }}
                    @else
                        {{ ucwords($value) }}
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="recommendation">
        <h3>Rekomendasi Servis</h3>
        @if($consultation->result_recommendation)
            <ul>
                @foreach(explode("\n", $consultation->result_recommendation) as $rec)
                    <li>{{ $rec }}</li>
                @endforeach
            </ul>
        @else
            <p><strong>Tidak ada tindakan servis khusus yang diperlukan.</strong></p>
        @endif
    </div>

    <div class="footer">
        <p>Dicetak otomatis oleh Sistem Pakar Rekomendasi Servis Kendaraan.</p>
    </div>
</body>
</html>
