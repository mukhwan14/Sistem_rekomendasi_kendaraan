<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tabungan Servis Driver') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Stats Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                <div class="p-8 text-center md:text-left md:flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium opacity-90">Total Dana Terkumpul</h3>
                        <p class="text-4xl font-bold mt-2">Rp {{ number_format($totalFunds, 0, ',', '.') }}</p>
                        <p class="text-sm mt-1 opacity-75">Dari {{ $earnings->count() }} hari penyetoran</p>
                    </div>
                    <div class="mt-6 md:mt-0 flex gap-3">
                        <form action="{{ route('daily_earnings.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menggunakan dana ini? Riwayat tabungan akan di-reset menjadi 0.');">
                            @csrf
                            <button type="submit" class="bg-white/20 text-white font-bold py-3 px-6 rounded-full hover:bg-white/30 transition border border-white/50">
                                Selesai Servis (Reset)
                            </button>
                        </form>
                        <a href="{{ route('daily_earnings.create') }}" class="bg-white text-indigo-600 font-bold py-3 px-6 rounded-full shadow hover:bg-gray-100 transition">
                            + Input Setoran Hari Ini
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recommendations Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Available Services -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">BISA DIAMBIL</span>
                            Rekomendasi Servis
                        </h3>
                        
                        @if($recommendedServices->count() > 0)
                            <div class="space-y-4">
                                @foreach($recommendedServices as $service)
                                    <div class="flex justify-between items-center p-4 border border-green-200 rounded-lg bg-green-50">
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $service->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $service->description }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-green-700 font-bold">Rp {{ number_format($service->cost, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>Belum ada servis yang terjangkau saat ini.</p>
                                <p class="text-sm">Yuk semangat nabung lagi!</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Targets -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 opacity-75">Target Berikutnya</h3>
                         <div class="space-y-4">
                            @foreach($allServices as $service)
                                @if($service->cost > $totalFunds)
                                    <div class="flex justify-between items-center p-3 border border-gray-100 rounded-lg opacity-60 hover:opacity-100 transition">
                                        <div>
                                            <h4 class="font-semibold text-gray-700">{{ $service->name }}</h4>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                                <div class="bg-indigo-400 h-1.5 rounded-full" style="width: {{ min(100, ($totalFunds / $service->cost) * 100) }}%"></div>
                                            </div>
                                        </div>
                                        <div class="text-right min-w-[100px]">
                                            <p class="text-gray-600">Rp {{ number_format($service->cost, 0, ',', '.') }}</p>
                                            <p class="text-xs text-red-500">Kurang Rp {{ number_format($service->cost - $totalFunds, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Setoran</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kondisi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masuk Tabungan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($earnings as $earning)
                                    <tr class="{{ $earning->status == 'used' ? 'bg-gray-50 opacity-60' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($earning->date)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Rp {{ number_format($earning->income, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($earning->vehicle_condition === 'layak')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Layak</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Perawatan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                             @if($earning->status == 'active')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Aktif</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Selesai/Terpakai</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $earning->status == 'active' ? 'text-indigo-600' : 'text-gray-500' }}">
                                            + Rp {{ number_format($earning->allocated_funds, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data setoran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
