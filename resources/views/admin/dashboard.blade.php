<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="bg-blue-600 rounded-2xl shadow-xl overflow-hidden mb-8 relative">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-500 opacity-30 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-blue-700 opacity-30 blur-3xl"></div>
                <div class="relative z-10 p-8 text-white">
                    <h2 class="text-3xl font-extrabold mb-2">Dashboard Administrator</h2>
                    <p class="text-blue-100 text-lg">Selamat datang kembali, {{ Auth::user()->name }}. Simak ringkasan aktivitas sistem hari ini.</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Total Users -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pengguna</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\User::count() }}</h3>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Consultations -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-l-4 border-green-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Konsultasi</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Consultation::count() }}</h3>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Rules -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border-l-4 border-purple-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Rules Aktif</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Rule::count() }}</h3>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Quick Actions -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Aksi Cepat
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.rules.index') }}" class="block w-full text-left px-4 py-3 bg-gray-50 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition duration-200 group flex justify-between items-center">
                                <span class="font-medium">Kelola Base Rules</span>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <a href="{{ route('admin.rules.create') }}" class="block w-full text-left px-4 py-3 bg-gray-50 hover:bg-green-50 hover:text-green-700 rounded-lg transition duration-200 group flex justify-between items-center">
                                <span class="font-medium">Buat Rule Baru</span>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </a>
                            <a href="{{ route('admin.diagnosis_questions.index') }}" class="block w-full text-left px-4 py-3 bg-gray-50 hover:bg-purple-50 hover:text-purple-700 rounded-lg transition duration-200 group flex justify-between items-center">
                                <span class="font-medium">Kelola Pertanyaan</span>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Table -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800">Aktivitas Terbaru</h3>
                            <a href="{{ route('consultation.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500">
                                    <tr>
                                        <th class="px-6 py-4">User</th>
                                        <th class="px-6 py-4">Kendaraan</th>
                                        <th class="px-6 py-4">Waktu</th>
                                        <th class="px-6 py-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach(\App\Models\Consultation::with('user')->latest()->take(5)->get() as $consultation)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $consultation->user->name }}</td>
                                        <td class="px-6 py-4">{{ $consultation->vehicle_brand }} ({{ $consultation->vehicle_year }})</td>
                                        <td class="px-6 py-4">{{ $consultation->created_at->diffForHumans() }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Selesai
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if(\App\Models\Consultation::count() == 0)
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">
                                            Belum ada aktivitas konsultasi.
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
