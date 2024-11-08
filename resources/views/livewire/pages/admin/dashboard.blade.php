<?php

use App\Models\{User, Lelang};
use function Livewire\Volt\{state};

state([
    'total_pengguna' => User::where('is_admin', 0)->count(),
    'total_lelang' => Lelang::count(),
    'total_pendapatan' => Lelang::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->where('status_pembayaran', 'validated')->sum('penawaran_akhir'),
]);

?>

<div class="sm:auto-rows-fr">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 2xl:grid-cols-3">
        <!-- Kartu Statistik Pengguna -->
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-slate-800">
            <div class="flex items-center">
                <div class="p-3 text-blue-500 bg-blue-100 rounded-full dark:bg-blue-500 dark:text-blue-100">
                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M2 22C2 17.5817 5.58172 14 10 14C14.4183 14 18 17.5817 18 22H16C16 18.6863 13.3137 16 10 16C6.68629 16 4 18.6863 4 22H2ZM10 13C6.685 13 4 10.315 4 7C4 3.685 6.685 1 10 1C13.315 1 16 3.685 16 7C16 10.315 13.315 13 10 13ZM10 11C12.21 11 14 9.21 14 7C14 4.79 12.21 3 10 3C7.79 3 6 4.79 6 7C6 9.21 7.79 11 10 11ZM18.2837 14.7028C21.0644 15.9561 23 18.752 23 22H21C21 19.564 19.5483 17.4671 17.4628 16.5271L18.2837 14.7028ZM17.5962 3.41321C19.5944 4.23703 21 6.20361 21 8.5C21 11.3702 18.8042 13.7252 16 13.9776V11.9646C17.6967 11.7222 19 10.264 19 8.5C19 7.11935 18.2016 5.92603 17.041 5.35635L17.5962 3.41321Z">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-slate-500 dark:text-slate-300">Total Pengguna</h4>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $total_pengguna }}</h2>
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
                    <h4 class="text-slate-500 dark:text-slate-300">Total Lelang</h4>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $total_lelang }}</h2>
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
                    <h4 class="text-slate-500 dark:text-slate-300">Pendapatan</h4>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Rp. {{
                        number_format($total_pendapatan, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>