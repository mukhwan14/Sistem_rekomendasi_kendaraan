<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Riwayat Konsultasi</h2>
                <a href="{{ route('consultation.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Konsultasi Baru
                </a>
            </div>

            @if($consultations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($consultations as $consultation)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 overflow-hidden flex flex-col">
                            <!-- Card Header -->
                            <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800">{{ $consultation->vehicle_brand }}</h3>
                                    <p class="text-sm text-gray-500">{{ $consultation->vehicle_type }} &bull; {{ $consultation->vehicle_year }}</p>
                                </div>
                                <div class="text-right">
                                     <span class="text-xs font-semibold text-gray-400 block">{{ $consultation->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-5 flex-grow">
                                <div class="mb-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-600">Hasil Analisa:</span>
                                    </div>
                                    
                                    @if($consultation->result_recommendation)
                                        <div class="bg-red-50 border border-red-100 rounded-lg p-3">
                                            <p class="text-xs font-bold text-red-600 uppercase tracking-wide mb-1">Perhatian Diperlukan</p>
                                            <p class="text-sm text-gray-700 line-clamp-2">{{ $consultation->result_recommendation }}</p>
                                        </div>
                                    @else
                                        <div class="bg-green-50 border border-green-100 rounded-lg p-3">
                                            <p class="text-xs font-bold text-green-600 uppercase tracking-wide mb-1">Kondisi Aman</p>
                                            <p class="text-sm text-gray-700">Kendaraan dalam kondisi prima.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <a href="{{ route('consultation.pdf', $consultation->id) }}" class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-200 transition" title="Download PDF">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                                <a href="{{ route('consultation.show', $consultation->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-dashed border-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada riwayat</h3>
                    <p class="text-gray-500 mb-6">Mulai konsultasi pertama Anda untuk mendapatkan rekomendasi perawatan.</p>
                    <a href="{{ route('consultation.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        + Konsultasi Baru
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
