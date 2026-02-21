<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-extrabold text-gray-800">Tambah Pertanyaan Baru</h2>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <form action="{{ route('admin.diagnosis_questions.store') }}" method="POST" x-data="{ type: 'select', options: [{value: '', label: ''}] }">
                        @csrf
                        
                        <!-- Question Label -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pertanyaan (Label) <span class="text-red-500">*</span></label>
                            <input type="text" name="question" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Bagaimana kondisi AC?" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Code Variable -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Variable (Unik) <span class="text-red-500">*</span></label>
                                <input type="text" name="code" list="variable_suggestions" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono" placeholder="ac_condition" required>
                                <datalist id="variable_suggestions">
                                    @foreach($existingVariables as $var)
                                        <option value="{{ $var }}">
                                    @endforeach
                                </datalist>
                                <p class="text-xs text-gray-500 mt-1">Saran dari Rules yang ada (bisa ketik baru jika perlu).</p>
                            </div>

                            <!-- Input Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Input <span class="text-red-500">*</span></label>
                                <select name="type" x-model="type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="select">Pilihan Ganda (Select)</option>
                                    <option value="number">Angka (Number)</option>
                                </select>
                            </div>
                        </div>

                         <!-- Dynamic Options Input (Only for Select) -->
                        <div x-show="type === 'select'" class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Jawaban</label>
                            
                            <template x-for="(option, index) in options" :key="index">
                                <div class="flex gap-2 mb-2">
                                    <input type="text" x-model="option.value" placeholder="Value (e.g. bad)" class="w-1/3 border-gray-300 rounded shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <input type="text" x-model="option.label" placeholder="Label (e.g. Buruk / Rusak)" class="w-2/3 border-gray-300 rounded shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <button type="button" @click="options.splice(index, 1)" class="text-red-500 hover:text-red-700 px-2 font-bold" x-show="options.length > 1">&times;</button>
                                </div>
                            </template>
                            
                            <button type="button" @click="options.push({value: '', label: ''})" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium">+ Tambah Opsi</button>

                            <!-- Hidden Input to store JSON -->
                            <input type="hidden" name="options" :value="JSON.stringify(options)">
                        </div>

                        <!-- Order & Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampilan <span class="text-red-500">*</span></label>
                                <input type="number" name="order" value="10" class="w-24 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div class="flex items-center mt-6">
                                <label for="is_active" class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 font-medium">Aktifkan Pertanyaan ini?</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.diagnosis_questions.index') }}" class="text-gray-600 hover:text-gray-900 py-2 px-4 transition">Batal</a>
                             <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition">
                                Simpan Pertanyaan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
