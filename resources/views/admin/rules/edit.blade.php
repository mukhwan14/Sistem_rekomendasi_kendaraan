<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-extrabold text-gray-800">Edit Rule: <span class="text-indigo-600">{{ $rule->code }}</span></h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Data Rule Form -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Informasi Dasar Rule</h3>
                            <form action="{{ route('admin.rules.update', $rule->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <label for="code" class="block text-sm font-medium text-gray-700">Kode Rule <span class="text-red-500">*</span></label>
                                        <input type="text" name="code" id="code" value="{{ $rule->code }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas <span class="text-red-500">*</span></label>
                                        <input type="number" name="priority" id="priority" value="{{ $rule->priority }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Rule <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ $rule->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $rule->description }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="recommendation" class="block text-sm font-medium text-gray-700">Rekomendasi Servis (Kalimat Penjelasan) <span class="text-red-500">*</span></label>
                                    <textarea name="recommendation" id="recommendation" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Contoh: Kami merekomendasikan servis ini karena...">{{ $rule->recommendation }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="action_list" class="block text-sm font-medium text-gray-700">Solusi Perbaikan / Checklist Servis <span class="text-red-500">*</span></label>
                                    <p class="text-xs text-gray-500 mb-1">Gunakan tombol <b>Enter</b> (Beda Baris) untuk memisahkan setiap poin solusi perbaikan.</p>
                                    <textarea name="action_list" id="action_list" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono" required placeholder="Ganti Oli Mesin&#10;Cek Filter Oli&#10;Kuras Radiator">{{ is_array($rule->action_list) ? implode("\n", $rule->action_list) : $rule->action_list }}</textarea>
                                </div>

                                <div class="mb-6">
                                    <label for="is_active" class="inline-flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ $rule->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700 font-medium">Aktif</span>
                                    </label>
                                </div>

                                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                                    <a href="{{ route('admin.rules.index') }}" class="text-gray-600 hover:text-gray-900 py-2 px-4 transition">Batal</a>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition">
                                        Perbarui Rule
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Manage Conditions Column -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                        <div class="p-6">
                            <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                                <h3 class="text-lg font-bold text-gray-900">IF Conditions</h3>
                                <a href="{{ route('admin.rule_conditions.create', ['rule_id' => $rule->id]) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded shadow text-xs">
                                    + Tambah
                                </a>
                            </div>

                            @if($rule->conditions->count() > 0)
                                <div class="space-y-3">
                                    @foreach($rule->conditions as $condition)
                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 relative group">
                                            <div class="text-sm font-mono text-gray-800">
                                                <span class="text-indigo-600">{{ $condition->fact_variable }}</span> 
                                                <span class="font-bold">{{ $condition->operator }}</span> 
                                                <span class="text-green-700">{{ $condition->value }}</span>
                                            </div>
                                            
                                            <form action="{{ route('admin.rule_conditions.destroy', $condition->id) }}" method="POST" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity" onsubmit="return confirm('Hapus kondisi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-100 text-red-600 hover:bg-red-200 p-1 rounded-full" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-6 text-gray-500 text-sm italic">
                                    Belum ada kondisi.<br>Pilih tambah kondisi.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
