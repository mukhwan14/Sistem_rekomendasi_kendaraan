<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Pertanyaan Baru</h2>

                    <form action="{{ route('admin.diagnosis_questions.store') }}" method="POST" x-data="{ type: 'select', options: [{value: '', label: ''}] }">
                        @csrf
                        
                        <!-- Question Label -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pertanyaan (Label)</label>
                            <input type="text" name="question" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Bagaimana kondisi AC?" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Code Variable -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Variable (Unik)</label>
                                <input type="text" name="code" list="variable_suggestions" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono" placeholder="ac_condition" required>
                                <datalist id="variable_suggestions">
                                    @foreach($existingVariables as $var)
                                        <option value="{{ $var }}">
                                    @endforeach
                                </datalist>
                                <p class="text-xs text-gray-500 mt-1">Saran dari Rules yang ada (bisa ketik baru jika perlu).</p>
                            </div>

                            <!-- Input Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Input</label>
                                <select name="type" x-model="type" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="select">Pilihan Ganda (Select)</option>
                                    <option value="number">Angka (Number)</option>
                                    <!-- boolean not used much here for simplicity, stick to select/number -->
                                </select>
                            </div>
                        </div>

                         <!-- Dynamic Options Input (Only for Select) -->
                        <div x-show="type === 'select'" class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Jawaban</label>
                            
                            <template x-for="(option, index) in options" :key="index">
                                <div class="flex gap-2 mb-2">
                                    <input type="text" x-model="option.value" placeholder="Value (e.g. bad)" class="w-1/3 border-gray-300 rounded shadow-sm text-sm">
                                    <input type="text" x-model="option.label" placeholder="Label (e.g. Buruk / Rusak)" class="w-2/3 border-gray-300 rounded shadow-sm text-sm">
                                    <button type="button" @click="options.splice(index, 1)" class="text-red-500 hover:text-red-700 px-2" x-show="options.length > 1">&times;</button>
                                </div>
                            </template>
                            
                            <button type="button" @click="options.push({value: '', label: ''})" class="mt-2 text-sm text-blue-600 hover:text-blue-800 font-medium">+ Tambah Opsi</button>

                            <!-- Hidden Input to store JSON -->
                            <input type="hidden" name="options" :value="JSON.stringify(options)">
                        </div>

                        <!-- Order -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampilan</label>
                            <input type="number" name="order" value="10" class="w-24 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t pt-6">
                            <a href="{{ route('admin.diagnosis_questions.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                             <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                                Simpan Pertanyaan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
