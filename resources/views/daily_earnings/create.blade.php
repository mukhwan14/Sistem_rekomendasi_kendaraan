<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Pendapatan Harian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('daily_earnings.store') }}" method="POST" x-data="{ income: '', formatRupiah(value) { return value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.'); } }">
                        @csrf

                        <!-- Tanggal -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <!-- Pendapatan -->
                        <div class="mb-4">
                            <label for="income" class="block text-sm font-medium text-gray-700">Pendapatan Hari Ini (Rp)</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="text" 
                                       id="income_display" 
                                       x-model="income" 
                                       @input="income = formatRupiah($event.target.value)"
                                       class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500" 
                                       placeholder="0" required>
                                <input type="hidden" name="income" :value="income.replace(/\./g, '')">
                            </div>
                        </div>



                        <div class="flex items-center justify-end">
                            <a href="{{ route('daily_earnings.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
