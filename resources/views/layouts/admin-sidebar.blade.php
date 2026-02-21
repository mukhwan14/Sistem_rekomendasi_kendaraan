<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-200 pb-4 gap-4">
                <h2 class="text-2xl font-extrabold text-gray-800">Monitoring Konsultasi</h2>
                
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <!-- Search Form -->
                    <form action="{{ route('admin.consultations.index') }}" method="GET" class="w-full sm:w-auto">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari User / Kendaraan..." 
                                   class="w-full sm:w-64 pl-10 pr-4 py-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </form>

                    <a href="{{ route('admin.consultations.export') }}" class="bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded shadow transition flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export Excel
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Hasil Rekomendasi</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($consultations as $consultation)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="font-bold text-gray-700">{{ $consultation->created_at->format('d M Y') }}</div>
                                            <div class="text-xs">{{ $consultation->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-1 mb-1">{{ $consultation->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $consultation->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <span class="font-bold border-b border-gray-100 pb-1 mb-1 block">{{ $consultation->vehicle_brand }}</span>
                                            <span class="text-xs text-gray-500">{{ $consultation->vehicle_type }} ({{ $consultation->vehicle_year }})</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            @if($consultation->result_recommendation)
                                                <div class="text-red-600 font-medium truncate w-64 px-2 py-1 bg-red-50 border border-red-100 rounded text-xs" title="{{ $consultation->result_recommendation }}">
                                                    {{ Str::limit($consultation->result_recommendation, 50) }}
                                                </div>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                    Kondisi Aman
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('consultation.show', $consultation->id) }}" class="inline-block text-indigo-600 hover:text-indigo-900 font-bold border border-indigo-200 px-3 py-1 rounded bg-indigo-50 hover:bg-indigo-100">Detail</a>
                                            <a href="{{ route('consultation.pdf', $consultation->id) }}" class="inline-block text-gray-500 hover:text-gray-700 border border-gray-200 px-3 py-1 rounded bg-gray-50 hover:bg-gray-100" title="Download PDF">
                                                PDF
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                            Tidak ada data konsultasi ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $consultations->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
