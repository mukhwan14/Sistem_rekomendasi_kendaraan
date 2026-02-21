<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-extrabold text-gray-800">Tambah Rule Baru</h2>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <form action="{{ route('admin.rules.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="code" class="block text-sm font-medium text-gray-700">Kode Rule <span class="text-red-500">*</span></label>
                                <input type="text" name="code" id="code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Contoh: R01">
                            </div>

                            <div class="mb-4">
                                <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas (Angka) <span class="text-red-500">*</span></label>
                                <input type="number" name="priority" id="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required value="0">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Rule <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Contoh: Rule Ganti Oli">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="recommendation" class="block text-sm font-medium text-gray-700">Rekomendasi Servis (Kalimat Penjelasan) <span class="text-red-500">*</span></label>
                            <textarea name="recommendation" id="recommendation" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Contoh: Kami merekomendasikan servis ini karena..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="action_list" class="block text-sm font-medium text-gray-700">Solusi Perbaikan / Checklist Servis <span class="text-red-500">*</span></label>
                            <p class="text-xs text-gray-500 mb-1">Gunakan tombol <b>Enter</b> (Beda Baris) untuk memisahkan setiap poin solusi perbaikan.</p>
                            <textarea name="action_list" id="action_list" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono" required placeholder="Ganti Oli Mesin&#10;Cek Filter Oli&#10;Kuras Radiator"></textarea>
                        </div>

                        <div class="mb-6">
                            <label for="is_active" class="inline-flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Aktifkan Rule ini?</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.rules.index') }}" class="text-gray-600 hover:text-gray-900 py-2 px-4 transition">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition">
                                Simpan Rule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
