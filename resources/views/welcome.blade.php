<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Sistem Pakar Kendaraan') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-50 text-gray-900 font-sans">
        <div class="min-h-screen flex flex-col selection:bg-red-500 selection:text-white">
            
            <!-- Navbar -->
            <nav class="w-full max-w-7xl mx-auto px-6 lg:px-8 py-6 flex justify-between items-center bg-gray-50 z-50">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="text-xl font-bold text-gray-800">AutoExpert</span>
                </div>
                <div>
                    @if (Route::has('login'))
                        <div class="flex gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </nav>

            <!-- Hero Section -->
            <main class="flex-grow w-full max-w-7xl mx-auto px-6 lg:px-8 flex flex-col lg:flex-row items-center justify-center gap-12 py-12 lg:py-20">
                <div class="lg:w-1/2 text-center lg:text-left z-10">
                    <h1 class="text-4xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                        Solusi Cerdas untuk <br>
                        <span class="text-blue-600">Perawatan Kendaraan</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Sistem pakar kami membantu Anda mendiagnosa kebutuhan servis kendaraan berdasarkan kondisi nyata dan kapasitas finansial Anda. Dapatkan rekomendasi akurat dalam hitungan detik.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700 transition duration-300">
                            Mulai Sekarang
                        </a>
                        <a href="#features" class="px-8 py-3 bg-white text-blue-600 font-bold rounded-lg shadow-md border border-gray-200 hover:bg-gray-50 transition duration-300">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                
                <div class="lg:w-1/2 w-full">
                   <!-- Illustration Placeholder using SVG -->
                   <div class="relative w-full max-w-lg mx-auto">
                        <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                        <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
                        <div class="relative bg-white p-8 rounded-2xl shadow-2xl border border-gray-100 z-10">
                            <div class="space-y-4">
                                <div class="flex items-center space-x-4 border-b border-gray-100 pb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">Analisis Cepat</div>
                                        <div class="text-xs text-gray-500">Mendeteksi masalah mesin dalam < 5 detik</div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4 border-b border-gray-100 pb-4">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">Hemat Biaya</div>
                                        <div class="text-xs text-gray-500">Rekomendasi sesuai budget Anda</div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">Laporan Lengkap</div>
                                        <div class="text-xs text-gray-500">Unduh hasil diagnosis format PDF</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Feature Highlights -->
            <section id="features" class="w-full max-w-7xl mx-auto px-6 lg:px-8 pb-20">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Mengapa Memilih Kami?</h2>
                    <p class="text-gray-600 mt-2">Teknologi sistem pakar yang memudahkan perawatan kendaraan Anda</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Metode Forward Chaining</h3>
                        <p class="text-gray-600">Menggunakan algoritma AI berbasis aturan untuk mencocokkan kondisi kendaraan dengan solusi yang tepat.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Dokumentasi Digital</h3>
                        <p class="text-gray-600">Riwayat konsultasi tersimpan aman dan dapat diunduh kapan saja sebagai referensi perawatan.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M12 12h.01M12 6h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Mudah Digunakan</h3>
                        <p class="text-gray-600">Antarmuka yang ramah pengguna, dirancang untuk semua kalangan tanpa perlu pengetahuan teknis mendalam.</p>
                    </div>
                </div>
            </section>

            <footer class="w-full bg-white py-6 mt-auto border-t border-gray-200 z-10">
                <div class="max-w-7xl mx-auto text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} AutoExpert System. All rights reserved.
                </div>
            </footer>
        </div>
    </body>
</html>
