<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistem Pakar Kendaraan') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white">
        <div class="min-h-screen flex">
            <!-- Left Side: Branding & Info (Hidden on Mobile) -->
            <div class="hidden lg:flex lg:w-1/2 bg-blue-600 text-white flex-col justify-between p-12 relative overflow-hidden">
                <!-- Background Shapes/Blobs for visual interest -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-blue-500 blur-3xl opacity-50"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-blue-700 blur-3xl opacity-50"></div>
                
                <div class="relative z-10">
                    <a href="/" class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="text-3xl font-bold tracking-tight">AutoExpert</span>
                    </a>
                    
                    <div class="mt-16">
                        <h1 class="text-5xl font-extrabold leading-tight">
                            Perawatan kendaraan <br>
                            jadi lebih mudah.
                        </h1>
                        <p class="mt-6 text-xl text-blue-100 max-w-lg leading-relaxed">
                            Dapatkan rekomendasi servis yang akurat dan sesuai budget dengan teknologi sistem pakar kami.
                        </p>
                    </div>

                    <div class="mt-12 space-y-4">
                        <div class="flex items-center gap-3 text-blue-100">
                             <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                             <span>Analisis Cepat & Akurat</span>
                        </div>
                        <div class="flex items-center gap-3 text-blue-100">
                             <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                             <span>Rekomendasi Hemat Biaya</span>
                        </div>
                        <div class="flex items-center gap-3 text-blue-100">
                             <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                             <span>Riwayat Servis Digital</span>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 text-sm text-blue-200">
                    &copy; {{ date('Y') }} AutoExpert System. All rights reserved.
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
                <div class="w-full max-w-md space-y-8">
                    <!-- Mobile Logo (visible only on mobile) -->
                    <div class="lg:hidden text-center mb-10">
                        <a href="/" class="inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="text-2xl font-bold text-gray-900">AutoExpert</span>
                        </a>
                    </div>
                    
                    <div>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
