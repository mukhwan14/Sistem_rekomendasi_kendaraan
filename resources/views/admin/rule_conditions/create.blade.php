<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-extrabold text-gray-800">
                    Tambah Kondisi untuk Rule: <span class="text-indigo-600">{{ $rule->name }} ({{ $rule->code }})</span>
                </h2>
            </div>
            
            <!-- Panduan Penggunaan (Tutorial) -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-blue-800">Cara Pengisian Form Kondisi:</h3>
                        <div class="mt-2 text-sm text-blue-700 space-y-2">
                            <p><strong>1. Variabel Fakta:</strong> Ini adalah daftar "Pertanyaan" yang akan muncul di form user. Pilih pertanyaan mana yang ingin dijadikan syarat.</p>
                            <p><strong>2. Nilai Pembanding:</strong> Ini adalah "Kunci Jawaban" yang diharapkan dari user. Berkat <i>update</i> terbaru, nilai ini akan <b>otomatis menjadi dropdown (pilihan)</b> jika variabel yang dipilih bertipe Pilihan Ganda!</p>
                            <p><strong>Contoh Logika:</strong> "JIKA [Kondisi Rem] [==] [Berbunyi] MAKA Rule ini akan direkomendasikan."</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <form action="{{ route('admin.rule_conditions.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="rule_id" value="{{ $rule->id }}">

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Variabel Fakta <span class="text-red-500">*</span></label>
                            <select name="fact_variable" id="fact_variable" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono" required>
                                <option value="" disabled selected>-- Pilih Variabel / Pertanyaan --</option>
                                @foreach($variables as $var)
                                    <option value="{{ $var->code }}">{{ $var->code }} ({{ $var->question }})</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1 font-medium">
                                Pilih kode dari Pertanyaan Diagnosa yang sudah ada agar tersinkronisasi.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Operator <span class="text-red-500">*</span></label>
                                <select name="operator" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono font-bold" required>
                                    <option value="==">== (Sama dengan)</option>
                                    <option value="!=">!= (Tidak sama)</option>
                                    <option value=">">&gt; (Lebih besar)</option>
                                    <option value="<">&lt; (Lebih kecil)</option>
                                    <option value=">=">&gt;= (Lebih besar atau sama)</option>
                                    <option value="<=">&lt;= (Lebih kecil atau sama)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Nilai <span class="text-xs font-normal text-green-600">(Otomatis)</span></label>
                                <select name="value_type" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100 focus:outline-none pointer-events-none text-sm text-gray-500" required tabindex="-1">
                                    <option value="string">Teks (String)</option>
                                    <option value="numeric">Angka (Numeric)</option>
                                    <option value="boolean">Boolean (Ya/Tidak)</option>
                                </select>
                            </div>

                             <div id="value-container">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Pembanding <span class="text-red-500">*</span></label>
                                <input type="text" name="value" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono bg-gray-100 cursor-not-allowed" 
                                       required disabled
                                       placeholder="Pilih Variabel Fakta dulu...">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.rules.edit', $rule->id) }}" class="text-gray-600 hover:text-gray-900 py-2 px-4 transition">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition">
                                Simpan Kondisi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variables = @json($variables);
            const factSelect = document.getElementById('fact_variable');
            const valueContainer = document.getElementById('value-container');
            const typeSelect = document.querySelector('select[name="value_type"]');

            factSelect.addEventListener('change', function() {
                const selectedCode = this.value;
                const variable = variables.find(v => v.code === selectedCode);
                
                if (!variable) return;

                // Auto set value type mostly to string unless it's numeric specifically
                if(variable.type === 'numeric') {
                    typeSelect.value = 'numeric';
                } else if(variable.type === 'radio' && variable.options.length === 2 && (variable.options[0].value === 'true' || variable.options[0].value === 'false')) {
                    typeSelect.value = 'boolean';
                } else {
                    typeSelect.value = 'string';
                }

                // Render dynamic input HTML
                let html = '<label class="block text-sm font-medium text-gray-700 mb-2">Nilai Pembanding <span class="text-red-500">*</span></label>';
                
                if (variable.type === 'select' || variable.type === 'radio') {
                    // It has options, render a select dropdown
                    html += `<select name="value" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono font-bold" required>`;
                    html += `<option value="" disabled selected>-- Pilih Opsi Jawaban --</option>`;
                    
                    variable.options.forEach(opt => {
                        html += `<option value="${opt.value}">${opt.value} - (${opt.label})</option>`;
                    });
                    
                    html += `</select>`;
                    html += `<p class="text-xs text-green-600 mt-1">Otomatis diload dari opsi Diagnosa.</p>`;
                } else if (variable.type === 'numeric') {
                    // Render number input
                    html += `<input type="number" name="value" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono" required placeholder="Contoh: 10000">`;
                } else {
                    // Fallback to text
                    html += `<input type="text" name="value" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono" required placeholder="Ketik nilai di sini...">`;
                }

                valueContainer.innerHTML = html;
            });
        });
    </script>
    @endpush
</x-app-layout>
