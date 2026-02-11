<x-app-layout>
    @push('scripts')
        <script src="//unpkg.com/alpinejs" defer></script>
    @endpush

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-blue-100">
                <div class="p-8 text-gray-900">
                    
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Mulai Konsultasi</h2>
                        <p class="text-gray-500 mt-2 text-lg">Lengkapi data kendaraan dan kondisi terkini untuk mendapatkan rekomendasi servis yang akurat.</p>
                    </div>

                    <form action="{{ route('consultation.store') }}" method="POST" x-data="{ 
                        income: '', 
                        formatRupiah(value) {
                            let number_string = value.replace(/[^,\d]/g, '').toString(),
                                split = number_string.split(','),
                                sisa = split[0].length % 3,
                                rupiah = split[0].substr(0, sisa),
                                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        
                            if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }
        
                            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                        }
                    }">
                        @csrf
                        
                        <!-- Section 1: Data Kendaraan -->
                        <div class="mb-10">
                            <h3 class="text-xl font-bold text-blue-800 border-b-2 border-blue-100 pb-2 mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Data Kendaraan
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kendaraan</label>
                                    <select name="vehicle_type" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3" required>
                                        <option value="Mobil">Mobil</option>
                                        <option value="Motor">Motor</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Merk & Tipe</label>
                                    <input type="text" name="vehicle_brand" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3" placeholder="Contoh: Toyota Avanza, Honda Vario" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kendaraan</label>
                                    <input type="number" name="vehicle_year" class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3" 
                                           min="1990" max="{{ date('Y') }}" value="{{ date('Y') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Diagnosa Kondisi (Dynamic Loop) -->
                        <div class="mb-10">
                            <h3 class="text-xl font-bold text-blue-800 border-b-2 border-blue-100 pb-2 mb-6 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Diagnosa Kondisi
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                @foreach($questions as $question)
                                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 hover:border-blue-200 transition-colors">
                                        <label class="block text-sm font-bold text-gray-800 mb-3">{{ $question->question }}</label>
                                        
                                        @if($question->type === 'number')
                                            @if($question->code === 'income')
                                                <!-- Special handling for Income (Rupiah) -->
                                                <div class="relative rounded-md shadow-sm">
                                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                                    </div>
                                                    <input type="text" 
                                                           x-model="income" 
                                                           @input="income = formatRupiah($event.target.value)" 
                                                           class="block w-full rounded-md border-gray-300 pl-10 focus:border-blue-500 focus:ring-blue-500 py-3 font-mono text-lg" 
                                                           placeholder="0" required>
                                                    <input type="hidden" name="facts[{{ $question->code }}]" :value="income.replace(/\./g, '')">
                                                </div>
                                            @else
                                                <!-- Standard Number Input -->
                                                <div class="relative rounded-md shadow-sm">
                                                    <input type="number" name="facts[{{ $question->code }}]" class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3 text-lg" placeholder="0" required>
                                                    @if($question->code === 'last_service_km')
                                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                                            <span class="text-gray-500 sm:text-sm">km</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        @elseif($question->type === 'select')
                                            <div class="space-y-2">
                                                @foreach($question->options as $option)
                                                    <label class="flex items-center p-3 rounded-lg border border-gray-200 bg-white hover:bg-blue-50 cursor-pointer transition">
                                                        <input type="radio" name="facts[{{ $question->code }}]" value="{{ $option['value'] }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" required>
                                                        <span class="ml-3 text-gray-700 font-medium">{{ $option['label'] }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                             <a href="{{ route('consultation.index') }}" class="text-gray-600 hover:text-gray-900 font-medium mr-6">Batal</a>
                             <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                                Analisa Kendaraan Saya
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
