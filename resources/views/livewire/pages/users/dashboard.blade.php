<?php

use App\Models\{Lelang, User};
use function Livewire\Volt\{mount, state};

mount(function () {
    $startOfToday = now();
    $endOfWeek = now()->addDays(7);
    $lelangMingguDepan = Lelang::with('motor.fotoMotor')->whereBetween('waktu_mulai_lelang', [$startOfToday, $endOfWeek])->where('status_lelang', 'akan datang')->get();
    [$this->lelangHariIni, $this->lelangTanpaHariIni] = $lelangMingguDepan->partition(function ($lelang) {
        return $lelang->waktu_mulai_lelang->isToday();
    });
});

state([
    'user' => User::withCount(['menangLelang', 'pesertaLelang'])->find(auth()->user()->id),
    'lelangHariIni',
    'lelangTanpaHariIni',
]);

?>
<div class="space-y-4 sm:auto-rows-fr md:space-y-8">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 2xl:grid-cols-3">
        <!-- Kartu Statistik Pengguna -->
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-slate-800">
            <div class="flex items-center">
                <div class="p-3 text-blue-500 bg-blue-100 rounded-full dark:bg-blue-500 dark:text-blue-100">
                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM6.00488 5.00275V9.00275C6.00488 12.3165 8.69117 15.0027 12.0049 15.0027C15.3186 15.0027 18.0049 12.3165 18.0049 9.00275V5.00275H6.00488ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-slate-500 dark:text-slate-300">Total Kemenangan</h4>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $user->menang_lelang_count }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Kartu Statistik Lelang -->
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-slate-800">
            <div class="flex items-center">
                <div class="p-3 text-red-500 bg-red-100 rounded-full dark:bg-red-500 dark:text-red-100">
                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M14.0049 20.0028V22.0028H2.00488V20.0028H14.0049ZM14.5907 0.689087L22.3688 8.46726L20.9546 9.88147L19.894 9.52792L17.4191 12.0028L23.076 17.6597L21.6617 19.0739L16.0049 13.417L13.6007 15.8212L13.8836 16.9525L12.4693 18.3668L4.69117 10.5886L6.10539 9.17437L7.23676 9.45721L13.53 3.16396L13.1765 2.1033L14.5907 0.689087ZM15.2978 4.22462L8.22671 11.2957L11.7622 14.8312L18.8333 7.76015L15.2978 4.22462Z">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-slate-500 dark:text-slate-300">Total Partisipasi</h4>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $user->peserta_lelang_count }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Kartu Statistik Pendapatan -->
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-slate-800">
            <div class="flex items-center">
                <div class="p-3 text-green-500 bg-green-100 rounded-full dark:bg-green-500 dark:text-green-100">
                    <!-- Icon Pendapatan -->
                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M22.0049 6.99979H23.0049V16.9998H22.0049V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V6.99979ZM20.0049 16.9998H14.0049C11.2435 16.9998 9.00488 14.7612 9.00488 11.9998C9.00488 9.23836 11.2435 6.99979 14.0049 6.99979H20.0049V4.99979H4.00488V18.9998H20.0049V16.9998ZM21.0049 14.9998V8.99979H14.0049C12.348 8.99979 11.0049 10.3429 11.0049 11.9998C11.0049 13.6566 12.348 14.9998 14.0049 14.9998H21.0049ZM14.0049 10.9998H17.0049V12.9998H14.0049V10.9998Z">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-slate-500 dark:text-slate-300">Saldo</h4>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Rp. {{
                        number_format($user->saldo, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4 xl:grid-cols-3 2xl:grid-cols-4">
        <div class="flex items-center justify-between col-span-full">
            <h1>Lelang Hari Ini</h1>
            <a href="{{ route('users.lelang.index') }}" wire:navigate
                class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-100 dark:focus-visible:outline-white">
                <span class="hidden md:block">Explore</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                    </path>
                </svg>
            </a>
        </div>
        @foreach ($lelangHariIni->take(4) as $lelang)
        <x-card-lelang :lelang="$lelang"></x-card-lelang>
        @endforeach
    </div>
    <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4 xl:grid-cols-3 2xl:grid-cols-4">
        <div class="flex items-center justify-between col-span-full">
            <h1>Lelang Akan Datang</h1>
            <a href="{{ route('users.lelang.index') }}" wire:navigate
                class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-100 dark:focus-visible:outline-white">
                <span class="hidden md:block">Explore</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                    </path>
                </svg>
            </a>
        </div>
        @foreach ($lelangTanpaHariIni->take(4) as $lelang)
        <x-card-lelang :lelang="$lelang"></x-card-lelang>
        @endforeach
    </div>
</div>