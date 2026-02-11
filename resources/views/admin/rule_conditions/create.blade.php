<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kondisi Rule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">
                        Tambah Kondisi untuk Rule: <span class="text-blue-600">{{ $rule->name }} ({{ $rule->code }})</span>
                    </h3>

                    <form action="{{ route('admin.rule_conditions.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="rule_id" value="{{ $rule->id }}">

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Variabel Fakta</label>
                            <input type="text" name="fact_variable" list="variable_suggestions"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                   required 
                                   placeholder="Contoh: income, oil_condition, last_service_km">
                            <datalist id="variable_suggestions">
                                @foreach($existingVariables as $var)
                                    <option value="{{ $var }}">
                                @endforeach
                            </datalist>
                            <p class="text-xs text-gray-500 mt-1">
                                Pilih kode dari pertanyaan (Diagnosis Questions) yang sudah ada agar sinkron.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Operator</label>
                                <select name="operator" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="==">== (Sama dengan)</option>
                                    <option value="!=">!= (Tidak sama dengan)</option>
                                    <option value=">">&gt; (Lebih dari)</option>
                                    <option value="<">&lt; (Kurang dari)</option>
                                    <option value=">=">&gt;= (Lebih dari atau sama)</option>
                                    <option value="<=">&lt;= (Kurang dari atau sama)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Nilai</label>
                                <select name="value_type" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="string">Teks (String)</option>
                                    <option value="numeric">Angka (Numeric)</option>
                                    <option value="boolean">Boolean (Ya/Tidak)</option>
                                </select>
                            </div>

                             <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Pembanding</label>
                                <input type="text" name="value" 
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                       required 
                                       placeholder="Nilai yang diharapkan">
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.rules.edit', $rule->id) }}" class="text-gray-600 hover:text-gray-900 mr-6 font-medium">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow hover:shadow-md transition">
                                Simpan Kondisi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
