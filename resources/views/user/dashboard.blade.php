<x-app-layout>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ── Summary Cards ─────────────────────────────────────────── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Total Tabungan Aktif --}}
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 text-white rounded-2xl shadow p-6 flex flex-col gap-1">
                    <span class="text-xs font-semibold uppercase opacity-75 tracking-wider">💰 Total Tabungan</span>
                    <span class="text-3xl font-extrabold">Rp {{ number_format($totalSavings, 0, ',', '.') }}</span>
                    <span class="text-xs opacity-70">Dana servis aktif terkumpul</span>
                    <a href="{{ route('daily_earnings.index') }}" class="mt-2 text-xs underline opacity-80 hover:opacity-100">Lihat detail →</a>
                </div>

                {{-- Hari Menabung --}}
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-1 border-l-4 border-blue-400">
                    <span class="text-xs font-semibold uppercase text-gray-500 tracking-wider">📅 Hari Menabung</span>
                    <span class="text-3xl font-extrabold text-gray-800">{{ $totalDays }} <span class="text-base font-medium text-gray-400">hari</span></span>
                    <span class="text-xs text-gray-500">Total hari input aktif</span>
                </div>

                {{-- Total Pendapatan --}}
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-1 border-l-4 border-green-400">
                    <span class="text-xs font-semibold uppercase text-gray-500 tracking-wider">📈 Total Pendapatan</span>
                    <span class="text-3xl font-extrabold text-gray-800">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</span>
                    <span class="text-xs text-gray-500">Akumulasi pendapatan aktif</span>
                </div>

                {{-- Rekomendasi Teratas --}}
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-1 border-l-4 border-yellow-400">
                    <span class="text-xs font-semibold uppercase text-gray-500 tracking-wider">🔧 Rekomendasi</span>
                    @if($latestRecommendation)
                        <span class="text-xl font-extrabold text-gray-800">{{ $latestRecommendation->name }}</span>
                        <span class="text-xs text-green-600 font-semibold">Rp {{ number_format($latestRecommendation->cost, 0, ',', '.') }} — Dana cukup!</span>
                    @else
                        <span class="text-lg font-bold text-gray-400">Belum ada</span>
                        <span class="text-xs text-gray-400">Terus menabung untuk buka rekomendasi</span>
                    @endif
                    <a href="{{ route('daily_earnings.index') }}" class="mt-2 text-xs text-indigo-500 underline hover:text-indigo-700">Lihat semua →</a>
                </div>
            </div>

            {{-- ── Quick Actions ─────────────────────────────────────────── --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('daily_earnings.create') }}"
                   class="flex items-center gap-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl p-5 shadow transition">
                    <div class="text-3xl">➕</div>
                    <div>
                        <div class="font-bold text-lg">Input Setoran Harian</div>
                        <div class="text-xs opacity-80">Catat pendapatan hari ini</div>
                    </div>
                </a>
                <a href="{{ route('daily_earnings.index') }}"
                   class="flex items-center gap-4 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl p-5 shadow transition">
                    <div class="text-3xl">💵</div>
                    <div>
                        <div class="font-bold text-lg text-gray-800">Tabungan Servis</div>
                        <div class="text-xs text-gray-500">Lihat saldo & rekomendasi</div>
                    </div>
                </a>
                <a href="{{ route('consultation.create') }}"
                   class="flex items-center gap-4 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl p-5 shadow transition">
                    <div class="text-3xl">🔍</div>
                    <div>
                        <div class="font-bold text-lg text-gray-800">Konsultasi Kendaraan</div>
                        <div class="text-xs text-gray-500">Periksa kondisi kendaraan</div>
                    </div>
                </a>
            </div>

            {{-- ── Charts ───────────────────────────────────────────────── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Daily Chart --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-bold text-gray-800">📊 Pendapatan & Tabungan (14 Hari Terakhir)</h3>
                    </div>
                    <canvas id="dailyChart" height="160"></canvas>
                </div>

                {{-- Monthly Chart --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-bold text-gray-800">📅 Ringkasan Bulanan (6 Bulan Terakhir)</h3>
                    </div>
                    <canvas id="monthlyChart" height="160"></canvas>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        const dailyLabels   = @json($dailyLabels);
        const dailyIncome   = @json($dailyIncome);
        const dailySavings  = @json($dailySavings);

        const monthlyLabels  = @json($monthlyLabels);
        const monthlyIncome  = @json($monthlyIncome);
        const monthlySavings = @json($monthlySavings);

        // ── Daily Chart ────────────────────────────────────────
        new Chart(document.getElementById('dailyChart'), {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [
                    {
                        label: 'Pendapatan (Rp)',
                        data: dailyIncome,
                        backgroundColor: 'rgba(99,102,241,0.6)',
                        borderRadius: 6,
                        order: 2,
                    },
                    {
                        label: 'Dana Servis (Rp)',
                        data: dailySavings,
                        type: 'line',
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245,158,11,0.15)',
                        borderWidth: 2,
                        pointRadius: 4,
                        tension: 0.4,
                        fill: true,
                        order: 1,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top' } },
                scales: {
                    y: {
                        ticks: {
                            callback: v => 'Rp ' + v.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        // ── Monthly Chart ──────────────────────────────────────
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [
                    {
                        label: 'Pendapatan (Rp)',
                        data: monthlyIncome,
                        backgroundColor: 'rgba(16,185,129,0.65)',
                        borderRadius: 6,
                    },
                    {
                        label: 'Dana Servis (Rp)',
                        data: monthlySavings,
                        backgroundColor: 'rgba(99,102,241,0.65)',
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top' } },
                scales: {
                    y: {
                        ticks: {
                            callback: v => 'Rp ' + v.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    </script>
    @endpush

</x-app-layout>
