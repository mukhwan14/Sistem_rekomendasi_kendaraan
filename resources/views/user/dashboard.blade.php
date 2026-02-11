<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="mb-6">Apa yang ingin Anda lakukan hari ini?</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('consultation.create') }}" class="block p-6 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition">
                            <h4 class="text-xl font-bold text-blue-800 mb-2">Mulai Konsultasi</h4>
                            <p class="text-blue-600">Periksa kondisi kendaraan Anda dan dapatkan rekomendasi servis.</p>
                        </a>

                        <a href="{{ route('consultation.index') }}" class="block p-6 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition">
                            <h4 class="text-xl font-bold text-green-800 mb-2">Riwayat Konsultasi</h4>
                            <p class="text-green-600">Lihat hasil pemeriksaan sebelumnya.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
