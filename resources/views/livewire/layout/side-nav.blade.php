<?php

use function Livewire\Volt\{state};
Use App\Livewire\Actions\Logout;

$role = auth()->user()->is_admin ? 'admin' : 'users';

state([
    'role' => $role,
    'isAdmin' => auth()->user()->is_admin,

    // User Routes
    'isInUserLelangHistory' => request()->routeIs('users.lelang.history'),
    
    // Admin & User Routes
    'isInDashboard' => request()->routeIs($role . '.dashboard'),
    'isInLelang' => request()->routeIs($role . '.lelang.*'),
    'isInLelangIndex' => request()->routeIs($role . '.lelang.index'),
    'isInLelangBayar' => request()->routeIs($role . '.lelang.bayar'),
    'isInProfile' => request()->routeIs('profile'),
    'isInSaldo' => request()->routeIs($role . '.saldo.*'),
    'isInPemenang' => request()->routeIs($role . '.pemenang.*'),

    // Admin Routes
    'isInAdminUsers' => request()->routeIs('admin.users.*'),
    'isInAdminLelangNasabah' => request()->routeIs('admin.lelang.nasabah'),
]);

$logout = function (Logout $logout) {
    $logout();

    $this->redirectRoute('login', navigate: true);
};
?>

{{-- Sidenav for Desktop --}}
<nav
    class="flex-col justify-between hidden px-3 pt-2 overflow-y-auto bg-white border-r-2 text-slate-700 dark:bg-slate-900 dark:text-slate-300 no-scrollbar xl:pt-5 xl:px-7 border-slate-300 dark:border-slate-700 sm:col-span-4 md:col-span-3 lg:col-span-2 sm:flex">
    <div class="space-y-4">
        <div class="space-y-1">
            <h5 class="px-2 font-bold uppercase text-slate-400 dark:text-slate-600">MENU</h5>
            <div class="space-y-1">
                <a href="{{ route($role . '.dashboard') }}" wire:navigate class="w-full flex justify-between items-center [&>svg]:size-5  px-2 py-1.5 {{ $isInDashboard ? 'bg-slate-100 dark:bg-slate-800 pointer-events-none' : ' hover:bg-slate-100
                    dark:hover:bg-slate-800' }}">
                    <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M14 21C13.4477 21 13 20.5523 13 20V12C13 11.4477 13.4477 11 14 11H20C20.5523 11 21 11.4477 21 12V20C21 20.5523 20.5523 21 20 21H14ZM4 13C3.44772 13 3 12.5523 3 12V4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V12C11 12.5523 10.5523 13 10 13H4ZM9 11V5H5V11H9ZM4 21C3.44772 21 3 20.5523 3 20V16C3 15.4477 3.44772 15 4 15H10C10.5523 15 11 15.4477 11 16V20C11 20.5523 10.5523 21 10 21H4ZM5 19H9V17H5V19ZM15 19H19V13H15V19ZM13 4C13 3.44772 13.4477 3 14 3H20C20.5523 3 21 3.44772 21 4V8C21 8.55228 20.5523 9 20 9H14C13.4477 9 13 8.55228 13 8V4ZM15 5V7H19V5H15Z">
                            </path>
                        </svg>
                        <span>{{ $isAdmin ? 'Dashboard' : 'Beranda' }}</span>
                    </div>
                </a>
                <div x-data="{
                        isExpanded: {{ $isInLelang ? 'true' : 'false' }},
                    }">
                    <button type="button" @click="isExpanded = !isExpanded"
                        class="w-full flex justify-between items-center [&>svg]:size-5 hover:bg-slate-100 dark:hover:bg-slate-800 px-2 py-1.5">
                        <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M14.0049 20.0028V22.0028H2.00488V20.0028H14.0049ZM14.5907 0.689087L22.3688 8.46726L20.9546 9.88147L19.894 9.52792L17.4191 12.0028L23.076 17.6597L21.6617 19.0739L16.0049 13.417L13.6007 15.8212L13.8836 16.9525L12.4693 18.3668L4.69117 10.5886L6.10539 9.17437L7.23676 9.45721L13.53 3.16396L13.1765 2.1033L14.5907 0.689087ZM15.2978 4.22462L8.22671 11.2957L11.7622 14.8312L18.8333 7.76015L15.2978 4.22462Z">
                                </path>
                            </svg>
                            <span>Lelang</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            x-bind:class="{ 'rotate-180': isExpanded }" class="duration-300">
                            <path
                                d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                            </path>
                        </svg>
                    </button>
                    <ul class="ml-3 mr-2" x-show="isExpanded" x-cloak x-collapse>
                        <li
                            class="pl-4 text-sm font-medium capitalize {{ $isInLelangIndex ? 'border-l-2 pointer-events-none text-rose-700 dark:text-rose-500 border-rose-700' : 'border-l hover:text-black dark:hover:text-white hover:border-l-2 border-slate-300 dark:border-slate-700 dark:hover:border-slate-200 hover:border-slate-800' }} ">
                            <a class="block py-2.5" href="{{ route($role . '.lelang.index') }}" wire:navigate>Lelang</a>
                        </li>
                        <li
                            class="pl-4 text-sm font-medium capitalize {{ $isInLelangBayar ? 'border-l-2 pointer-events-none text-rose-700 dark:text-rose-500 border-rose-700' : 'border-l hover:text-black dark:hover:text-white hover:border-l-2 border-slate-300 dark:border-slate-700 dark:hover:border-slate-200 hover:border-slate-800' }} ">
                            <a class="block py-2.5" href="{{ route($role . '.lelang.bayar') }}"
                                wire:navigate>Pembayaran</a>
                        </li>
                        @if ($isAdmin)
                        <li
                            class="pl-4 text-sm font-medium capitalize {{ $isInAdminLelangNasabah ? 'border-l-2 pointer-events-none text-rose-700 dark:text-rose-500 border-rose-700' : 'border-l hover:text-black dark:hover:text-white hover:border-l-2 border-slate-300 dark:border-slate-700 dark:hover:border-slate-200 hover:border-slate-800' }} ">
                            <a class="block py-2.5" href="{{ route('admin.lelang.nasabah') }}" wire:navigate>Nasabah</a>
                        </li>
                        @else
                        <li
                            class="pl-4 text-sm font-medium capitalize {{ $isInUserLelangHistory ? 'border-l-2 pointer-events-none text-rose-700 dark:text-rose-500 border-rose-700' : 'border-l hover:text-black dark:hover:text-white hover:border-l-2 border-slate-300 dark:border-slate-700 dark:hover:border-slate-200 hover:border-slate-800' }} ">
                            <a class="block py-2.5" href="{{ route('users.lelang.history') }}" wire:navigate>History</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        @if ($isAdmin)
        <div class="space-y-1">
            <h5 class="px-2 font-bold uppercase text-slate-400 dark:text-slate-600">REPORT</h5>
            <div class="space-y-1">
                <a href="#"
                    class="w-full flex justify-between items-center [&>svg]:size-5 hover:bg-slate-100 dark:hover:bg-slate-800 px-2 py-1.5">
                    <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM12 8V12H16C16 14.2091 14.2091 16 12 16C9.79086 16 8 14.2091 8 12C8 9.79086 9.79086 8 12 8Z">
                            </path>
                        </svg>
                        <span>Rekap</span>
                    </div>
                </a>
                <div x-data="{
                        isExpanded: false,
                    }">
                    <button type="button" @click="isExpanded = !isExpanded"
                        class="w-full flex justify-between items-center [&>svg]:size-5 hover:bg-slate-100 dark:hover:bg-slate-800 px-2 py-1.5">
                        <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M11 7H13V17H11V7ZM15 11H17V17H15V11ZM7 13H9V17H7V13ZM15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                                </path>
                            </svg>
                            <span>Laporan</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            x-bind:class="{ 'rotate-180': isExpanded }" class="duration-300">
                            <path
                                d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                            </path>
                        </svg>
                    </button>
                    <ul class="ml-3 mr-2" x-show="isExpanded" x-cloak x-collapse>
                        <li
                            class="pl-4 text-sm font-medium capitalize border-l hover:text-black dark:hover:text-white hover:border-l-2 border-slate-300 dark:border-slate-700 dark:hover:border-slate-200 hover:border-slate-800">
                            <a class="block py-2.5" href="#">Kendaraan Terjual</a>
                        </li>
                        <li
                            class="pl-4 text-sm font-medium capitalize border-l hover:text-black dark:hover:text-white hover:border-l-2 border-slate-300 dark:border-slate-700 dark:hover:border-slate-200 hover:border-slate-800">
                            <a class="block py-2.5" href="#">Peserta Lelang</a>
                        </li>
                        <li
                            class="pl-4 text-sm font-medium capitalize border-l hover:text-black dark:hover:text-white hover:border-l-2 border-slate-300 dark:border-slate-700 dark:hover:border-slate-200 hover:border-slate-800">
                            <a class="block py-2.5" href="#">Nasabah</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="space-y-1">
            <div class="flex items-center justify-between">
                <h5 class="px-2 font-bold uppercase text-slate-400 dark:text-slate-600">USER</h5>
                @if ($isAdmin)
                <a href="{{ route('admin.users.create') }}" wire:navigate
                    class="[&>svg]:size-5 px-3 py-2 text-sm font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl  hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:focus-visible:outline-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path>
                    </svg>
                </a>
                @endif
            </div>
            <div class="space-y-1">
                @if ($isAdmin)
                <a href="{{ route('admin.users.index') }}" wire:navigate class="w-full flex justify-between items-center [&>svg]:size-5  px-2 py-1.5 {{ $isInAdminUsers ? 'bg-slate-100 dark:bg-slate-800 pointer-events-none' : ' hover:bg-slate-100
                    dark:hover:bg-slate-800' }}">
                    <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z">
                            </path>
                        </svg>
                        <span>Data User</span>
                    </div>
                </a>
                @endif
                <a href="{{ route($role . '.saldo.index') }}" wire:navigate class="w-full flex justify-between items-center [&>svg]:size-5 px-2 py-1.5 {{ $isInSaldo ? 'bg-slate-100 dark:bg-slate-800 pointer-events-none' : ' hover:bg-slate-100
                dark:hover:bg-slate-800' }}">
                    <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M22.0049 6.99979H23.0049V16.9998H22.0049V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V6.99979ZM20.0049 16.9998H14.0049C11.2435 16.9998 9.00488 14.7612 9.00488 11.9998C9.00488 9.23836 11.2435 6.99979 14.0049 6.99979H20.0049V4.99979H4.00488V18.9998H20.0049V16.9998ZM21.0049 14.9998V8.99979H14.0049C12.348 8.99979 11.0049 10.3429 11.0049 11.9998C11.0049 13.6566 12.348 14.9998 14.0049 14.9998H21.0049ZM14.0049 10.9998H17.0049V12.9998H14.0049V10.9998Z">
                            </path>
                        </svg>
                        <span>Saldo</span>
                    </div>
                </a>
                <a href="{{ route($role . '.pemenang.index') }}" wire:navigate class="w-full flex justify-between items-center [&>svg]:size-5 {{ $isInPemenang ? 'bg-slate-100 dark:bg-slate-800 pointer-events-none' : ' hover:bg-slate-100
                    dark:hover:bg-slate-800' }} px-2 py-1.5">
                    <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM6.00488 5.00275V9.00275C6.00488 12.3165 8.69117 15.0027 12.0049 15.0027C15.3186 15.0027 18.0049 12.3165 18.0049 9.00275V5.00275H6.00488ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z">
                            </path>
                        </svg>
                        <span>Pemenang</span>
                    </div>
                </a>
                <a href="{{ route('profile') }}" wire:navigate class="w-full flex justify-between items-center [&>svg]:size-5  px-2 py-1.5 {{ $isInProfile ? 'bg-slate-100 dark:bg-slate-800 pointer-events-none' : ' hover:bg-slate-100
                                    dark:hover:bg-slate-800' }}">
                    <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M21.0082 3C21.556 3 22 3.44495 22 3.9934V20.0066C22 20.5552 21.5447 21 21.0082 21H2.9918C2.44405 21 2 20.5551 2 20.0066V3.9934C2 3.44476 2.45531 3 2.9918 3H21.0082ZM20 5H4V19H20V5ZM18 15V17H6V15H18ZM12 7V13H6V7H12ZM18 11V13H14V11H18ZM10 9H8V11H10V9ZM18 7V9H14V7H18Z">
                            </path>
                        </svg>
                        <span>Profile</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div
        class="sticky bottom-0 flex justify-center py-2 bg-white border-t-2 dark:text-slate-300 border-slate-300 dark:bg-slate-900 dark:border-slate-700">
        <button type="button" wire:click="logout"
            class="[&>svg]:size-5 flex-1 px-3 py-2 text-sm font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
            Sign Out
        </button>
    </div>
</nav>