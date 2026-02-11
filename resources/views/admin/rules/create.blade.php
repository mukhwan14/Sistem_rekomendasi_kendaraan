<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.rules.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="code" class="block text-sm font-medium text-gray-700">Kode Rule</label>
                            <input type="text" name="code" id="code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required placeholder="Contoh: R01">
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Rule</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required placeholder="Contoh: Rule Ganti Oli">
                        </div>

                        <div class="mb-4">
                            <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas (Angka)</label>
                            <input type="number" name="priority" id="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required value="0">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="recommendation" class="block text-sm font-medium text-gray-700">Rekomendasi Servis</label>
                            <textarea name="recommendation" id="recommendation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required placeholder="Contoh: Lakukan ganti oli mesin dan cek filter oli"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded border-gray-300 text-indigo-600 shadow-sm">
                                <span class="ml-2 text-sm text-gray-600">Aktifkan Rule ini?</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Rule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
