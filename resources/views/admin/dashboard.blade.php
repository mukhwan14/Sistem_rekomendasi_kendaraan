<x-app-layout>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ── Welcome Banner ───────────────────────────────────────────── --}}
            <div class="relative bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl shadow-xl overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 200">
                        <circle cx="700" cy="100" r="180" fill="white"/>
                        <circle cx="50"  cy="50"  r="100" fill="white"/>
                    </svg>
                </div>
                <div class="relative z-10 p-8 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold">Dashboard Administrator</h2>
                        <p class="text-blue-100 mt-1">Selamat datang kembali, <span class="font-bold">{{ Auth::user()->name }}</span>. Simak ringkasan sistem hari ini.</p>
                    </div>
                    <div class="text-right text-sm text-blue-100 opacity-80">
                        <div class="text-2xl font-bold text-white">{{ now()->translatedFormat('d M Y') }}</div>
                        <div>{{ now()->translatedFormat('l') }}</div>
                    </div>
                </div>
            </div>

            {{-- ── Stats Cards ──────────────────────────────────────────────── --}}
            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 col-span-1">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total User</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 col-span-1">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Konsultasi</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalConsultations }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500 col-span-1">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Rules Aktif</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalRules }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500 col-span-1">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis Servis</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalServices }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-indigo-500 col-span-1">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Setoran Hari Ini</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $todayEarnings }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-pink-500 col-span-1">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Dana Aktif</p>
                    <p class="text-xl font-extrabold text-gray-800 mt-1">Rp {{ number_format($totalFundsAllUsers, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- ── Quick Actions ────────────────────────────────────────────── --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <a href="{{ route('admin.rules.create') }}" class="flex items-center gap-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl p-4 shadow transition">
                    <span class="text-2xl">➕</span>
                    <span class="text-sm font-semibold">Buat Rule Baru</span>
                </a>
                <a href="{{ route('admin.rules.index') }}" class="flex items-center gap-3 bg-white hover:bg-gray-50 border rounded-xl p-4 shadow transition">
                    <span class="text-2xl">📋</span>
                    <span class="text-sm font-semibold text-gray-700">Kelola Rules</span>
                </a>
                <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 bg-white hover:bg-gray-50 border rounded-xl p-4 shadow transition">
                    <span class="text-2xl">🔧</span>
                    <span class="text-sm font-semibold text-gray-700">Kelola Servis</span>
                </a>
                <a href="{{ route('admin.consultations.index') }}" class="flex items-center gap-3 bg-white hover:bg-gray-50 border rounded-xl p-4 shadow transition">
                    <span class="text-2xl">📊</span>
                    <span class="text-sm font-semibold text-gray-700">Laporan</span>
                </a>
            </div>

            {{-- ── Charts ────────────────────────────────────────────────────── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="text-base font-bold text-gray-800 mb-4">📊 Total Setoran Semua Driver (14 Hari Terakhir)</h3>
                    <canvas id="dailyChart" height="170"></canvas>
                </div>
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="text-base font-bold text-gray-800 mb-4">📅 Ringkasan Pendapatan Bulanan (6 Bulan)</h3>
                    <canvas id="monthlyChart" height="170"></canvas>
                </div>
            </div>

            {{-- ── Recent Consultations ──────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-base font-bold text-gray-800">🕑 Konsultasi Terbaru</h3>
                    <a href="{{ route('admin.consultations.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm text-gray-700">
                        <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500">
                            <tr>
                                <th class="px-6 py-3 text-left">User</th>
                                <th class="px-6 py-3 text-left">Kendaraan</th>
                                <th class="px-6 py-3 text-left">Waktu</th>
                                <th class="px-6 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentConsultations as $c)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $c->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $c->vehicle_brand ?? '-' }} ({{ $c->vehicle_year ?? '-' }})</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $c->created_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Selesai</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">Belum ada aktivitas konsultasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        new Chart(document.getElementById('dailyChart'), {
            type: 'bar',
            data: {
                labels: @json($dailyLabels),
                datasets: [
                    {
                        label: 'Total Pendapatan (Rp)',
                        data: @json($dailyTotal),
                        backgroundColor: 'rgba(99,102,241,0.65)',
                        borderRadius: 6,
                        order: 2,
                    },
                    {
                        label: 'Dana Servis (Rp)',
                        data: @json($dailySaved),
                        type: 'line',
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245,158,11,0.1)',
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
                scales: { y: { ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } }
            }
        });

        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: @json($monthlyLabels),
                datasets: [
                    {
                        label: 'Total Pendapatan (Rp)',
                        data: @json($monthlyIncome),
                        backgroundColor: 'rgba(16,185,129,0.65)',
                        borderRadius: 6,
                    },
                    {
                        label: 'Dana Servis (Rp)',
                        data: @json($monthlySaved),
                        backgroundColor: 'rgba(99,102,241,0.65)',
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top' } },
                scales: { y: { ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } }
            }
        });
    </script>
    @endpush

</x-app-layout>
