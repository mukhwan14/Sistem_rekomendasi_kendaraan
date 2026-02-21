<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex flex-col sm:flex-row justify-between items-center border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-extrabold text-gray-800">Kelola Daftar Servis</h2>
                <a href="{{ route('admin.services.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded shadow transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Servis
                </a>
            </div>

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 border border-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Servis</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Biaya (Rp)</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($services as $service)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $service->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $service->description ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm font-bold text-indigo-700">Rp {{ number_format($service->cost, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm text-center space-x-2">
                                            <a href="{{ route('admin.services.edit', $service) }}"
                                               class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-bold py-1 px-3 rounded shadow-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline-block"
                                                  onsubmit="return confirm('Hapus servis ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1 px-3 rounded shadow-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                            Belum ada data servis. <a href="{{ route('admin.services.create') }}" class="text-indigo-600 font-semibold">Tambah sekarang</a>.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
