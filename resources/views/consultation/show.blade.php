<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                
                <!-- Header Status -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white sm:rounded-t-2xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold">Hasil Analisa Konsultasi</h2>
                            <p class="text-blue-100 text-sm mt-1">ID: #{{ $consultation->id }} &bull; {{ $consultation->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                        <div class="hidden sm:block">
                            <span class="px-4 py-2 bg-white/20 rounded-full text-sm font-semibold backdrop-blur-sm">
                                Status: Selesai
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-8 text-gray-900 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column: Details & Facts -->
                    <div class="lg:col-span-1 space-y-6">
                        
                        <!-- Vehicle Data -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                                Kendaraan
                            </h3>
                            <ul class="space-y-3 text-sm">
                                <li class="flex justify-between">
                                    <span class="text-gray-500">Jenis:</span>
                                    <span class="font-medium">{{ $consultation->vehicle_type }}</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-500">Merk/Tipe:</span>
                                    <span class="font-medium">{{ $consultation->vehicle_brand }}</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-500">Tahun:</span>
                                    <span class="font-medium">{{ $consultation->vehicle_year }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Input Facts -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Kondisi Tercatat
                            </h3>
                            <ul class="space-y-3 text-sm">
                                <li class="flex justify-between items-center border-b border-gray-200 pb-2">
                                    <span class="text-gray-500">Jarak Tempuh:</span>
                                    <span class="font-medium">{{ number_format($consultation->input_facts['last_service_km'] ?? 0, 0, ',', '.') }} km</span>
                                </li>
                                <li class="flex justify-between items-center border-b border-gray-200 pb-2">
                                    <span class="text-gray-500">Income/Bulan:</span>
                                    <span class="font-medium text-green-600">Rp {{ number_format($consultation->input_facts['income'] ?? 0, 0, ',', '.') }}</span>
                                </li>
                                @foreach($consultation->input_facts as $key => $value)
                                    @if(!in_array($key, ['last_service_km', 'income']))
                                        <li class="flex justify-between items-center border-b border-gray-200 pb-2 last:border-0">
                                            <span class="text-gray-500 capitalize">{{ str_replace('_', ' ', $key) }}:</span>
                                            <span class="font-medium capitalize text-gray-800">{{ $value }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Right Column: Recommendations (Explainable AI) -->
                    <div class="lg:col-span-2">
                        <div class="bg-blue-50 rounded-xl p-8 border border-blue-100 h-full relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 rounded-full bg-blue-100 opacity-50 blur-2xl"></div>
                            
                            <h3 class="text-2xl font-bold text-blue-800 mb-6 flex items-center gap-3 relative z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Rekomendasi Servis
                            </h3>
                            
                            @if(isset($rules) && $rules->isNotEmpty())
                                <ul class="space-y-6 relative z-10">
                                    @foreach($rules as $rule)
                                        <li class="bg-white p-5 rounded-lg shadow-sm border border-blue-100">
                                            <!-- Rule Name -->
                                            <div class="font-bold text-lg text-blue-900 mb-2 flex items-start gap-2">
                                                <span class="text-yellow-500 mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                {{ $rule->name }}
                                            </div>

                                            <!-- The "Why" Logic -->
                                            <div class="ml-7">
                                                <p class="text-xs font-bold text-blue-500 uppercase tracking-wider mb-2">Mengapa rekomendasi ini muncul?</p>
                                                <ul class="list-disc list-inside text-sm text-gray-700 bg-gray-50 p-3 rounded border border-gray-200 mb-4">
                                                    @foreach($rule->conditions as $condition)
                                                        <li>
                                                            Kondisi 
                                                            <span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $condition->sub_criteria)) }}</span> 
                                                            {{ $condition->operator }} 
                                                            <span class="font-medium text-blue-700">
                                                                {{ is_numeric($condition->value) ? number_format($condition->value) : ucfirst($condition->value) }}
                                                            </span>
                                                            @if($condition->sub_criteria == 'last_service_km') (km) @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                
                                                <!-- Action List -->
                                                <div>
                                                    <span class="font-bold text-xs uppercase text-green-600 tracking-wider">Solusi Perbaikan:</span>
                                                    <ul class="mt-2 space-y-2">
                                                        @php
                                                            $actions = is_array($rule->action_list) ? $rule->action_list : (json_decode($rule->action_list, true) ?? []);
                                                            if (!is_array($actions)) {
                                                                $actions = [$rule->action_list]; // fallback if it's just a plain string
                                                            }
                                                        @endphp
                                                        @foreach($actions as $action)
                                                            <li class="flex items-start gap-2 text-sm text-gray-800">
                                                                <svg class="w-4 h-4 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                {{ $action }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif($consultation->result_recommendation)
                                <!-- Fallback for old data without matched rules -->
                                <div class="space-y-4 relative z-10">
                                    @foreach(explode("\n", $consultation->result_recommendation) as $rec)
                                        @if(trim($rec))
                                            <div class="flex gap-3 bg-white p-4 rounded-lg shadow-sm border border-blue-100">
                                                <div class="mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <p class="text-gray-800 font-medium text-lg leading-relaxed">{{ $rec }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-green-100 p-6 rounded-lg border border-green-200 text-center relative z-10">
                                    <p class="text-green-800 font-bold text-lg">Kondisi Prima!</p>
                                    <p class="text-green-600">Tidak ada rekomendasi servis khusus yang diperlukan saat ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Footer Actions -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 sm:rounded-b-2xl">
                    <a href="{{ route('consultation.create') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Konsultasi Ulang
                    </a>
                    
                    <div class="flex gap-3">
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.consultations.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition shadow-sm">
                                Kembali ke Laporan
                            </a>
                        @else
                            <a href="{{ route('consultation.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition shadow-sm">
                                Kembali ke Riwayat
                            </a>
                        @endif
                        <a href="{{ route('consultation.pdf', $consultation->id) }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold shadow-md hover:shadow-lg transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download PDF Lengkap
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
