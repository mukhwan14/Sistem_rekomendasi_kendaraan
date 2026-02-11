<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Update Rule Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar Rule</h3>
                    <form action="{{ route('admin.rules.update', $rule->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="code" class="block text-sm font-medium text-gray-700">Kode Rule</label>
                                <input type="text" name="code" id="code" value="{{ $rule->code }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>

                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Rule</label>
                                <input type="text" name="name" id="name" value="{{ $rule->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas</label>
                            <input type="number" name="priority" id="priority" value="{{ $rule->priority }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ $rule->description }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="recommendation" class="block text-sm font-medium text-gray-700">Rekomendasi Servis</label>
                            <textarea name="recommendation" id="recommendation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ $rule->recommendation }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $rule->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm">
                                <span class="ml-2 text-sm text-gray-600">Aktif</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Rule
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Manage Conditions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Kondisi (IF Conditions)</h3>
                        <!-- Button to open modal or redirect to add condition -->
                        <a href="{{ route('admin.rule_conditions.create', ['rule_id' => $rule->id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                            + Tambah Kondisi
                        </a>
                    </div>

                    @if($rule->conditions->count() > 0)
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="py-2 px-4 border-b">Variabel</th>
                                    <th class="py-2 px-4 border-b">Operator</th>
                                    <th class="py-2 px-4 border-b">Nilai</th>
                                    <th class="py-2 px-4 border-b">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rule->conditions as $condition)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $condition->fact_variable }}</td>
                                        <td class="py-2 px-4 border-b text-center">{{ $condition->operator }}</td>
                                        <td class="py-2 px-4 border-b">{{ $condition->value }}</td>
                                        <td class="py-2 px-4 border-b text-center">
                                            <form action="{{ route('admin.rule_conditions.destroy', $condition->id) }}" method="POST" onsubmit="return confirm('Hapus kondisi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500 italic">Belum ada kondisi yang diatur untuk rule ini.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
