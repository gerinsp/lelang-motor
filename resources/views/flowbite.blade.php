<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{isDark: $persist(false)}"
    :class="{'dark': isDark}" @keydown.ctrl.space="isDark = !isDark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body
    class="flex flex-col h-screen overflow-y-hidden font-sans antialiased transition-colors duration-300 bg-white sm:grid sm:grid-cols-12 sm:grid-rows-[max-content,1fr] text-slate-700 dark:bg-slate-900 dark:text-slate-300">
    {{-- Top Navigation --}}
    <header
        class="flex items-center justify-between gap-4 px-6 py-4 border-b sm:col-span-full bg-slate-100 dark:bg-slate-800 border-slate-300 dark:border-slate-700"
        aria-label="penguin ui menu">
        <!-- Brand Logo -->
        <a href="#" class="text-2xl font-bold text-black dark:text-white">
            <span>Lelang <span class="text-rose-700 dark:text-rose-600">Kertamulia</span></span>
            <!-- <img src="./your-logo.svg" alt="brand logo" class="w-10" /> -->
        </a>
        <!-- Desktop Menu -->
        <ul class="items-center flex-shrink-0 hidden gap-4 sm:flex">
            <li>
                <button type="button" title="sign out"
                    class="[&>svg]:size-5 px-3 py-2 text-sm font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M4 18H6V20H18V4H6V6H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V18ZM6 11H13V13H6V16L1 12L6 8V11Z">
                        </path>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" title="Cari lelang"
                    class="[&>svg]:size-5 px-3 py-2 text-sm font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M11 2C15.968 2 20 6.032 20 11C20 15.968 15.968 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2ZM11 18C14.8675 18 18 14.8675 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18ZM19.4853 18.0711L22.3137 20.8995L20.8995 22.3137L18.0711 19.4853L19.4853 18.0711Z">
                        </path>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" title="notifikasi"
                    class="relative [&>svg]:size-5 px-3 py-2 text-sm font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M20 17H22V19H2V17H4V10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10V17ZM18 17V10C18 6.68629 15.3137 4 12 4C8.68629 4 6 6.68629 6 10V17H18ZM9 21H15V23H9V21Z">
                        </path>
                    </svg>
                    <div
                        class="absolute top-0 inline-flex items-center justify-center text-xs font-bold text-white bg-red-600 border-2 border-white rounded-full dark:bg-red-500 size-3 end-0 dark:border-gray-800">
                    </div>
                </button>
            </li>
            <li>
                <button type="button" @click="isDark = !isDark" title="Tema"
                    class="[&>svg]:size-5 px-3 py-2 text-sm font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
                    <svg x-show="!isDark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M10 7C10 10.866 13.134 14 17 14C18.9584 14 20.729 13.1957 21.9995 11.8995C22 11.933 22 11.9665 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C12.0335 2 12.067 2 12.1005 2.00049C10.8043 3.27098 10 5.04157 10 7ZM4 12C4 16.4183 7.58172 20 12 20C15.0583 20 17.7158 18.2839 19.062 15.7621C18.3945 15.9187 17.7035 16 17 16C12.0294 16 8 11.9706 8 7C8 6.29648 8.08133 5.60547 8.2379 4.938C5.71611 6.28423 4 8.9417 4 12Z">
                        </path>
                    </svg>
                    <svg x-show="isDark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 18C8.68629 18 6 15.3137 6 12C6 8.68629 8.68629 6 12 6C15.3137 6 18 8.68629 18 12C18 15.3137 15.3137 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16ZM11 1H13V4H11V1ZM11 20H13V23H11V20ZM3.51472 4.92893L4.92893 3.51472L7.05025 5.63604L5.63604 7.05025L3.51472 4.92893ZM16.9497 18.364L18.364 16.9497L20.4853 19.0711L19.0711 20.4853L16.9497 18.364ZM19.0711 3.51472L20.4853 4.92893L18.364 7.05025L16.9497 5.63604L19.0711 3.51472ZM5.63604 16.9497L7.05025 18.364L4.92893 20.4853L3.51472 19.0711L5.63604 16.9497ZM23 11V13H20V11H23ZM4 11V13H1V11H4Z">
                        </path>
                    </svg>
                </button>
            </li>
            <!-- User Pic -->
            <li x-data="{ userDropDownIsOpen: false, openWithKeyboard: false }"
                @keydown.esc.window="userDropDownIsOpen = false, openWithKeyboard = false"
                class="relative flex items-center">
                <button @click="userDropDownIsOpen = ! userDropDownIsOpen" :aria-expanded="userDropDownIsOpen"
                    @keydown.space.prevent="openWithKeyboard = true" @keydown.enter.prevent="openWithKeyboard = true"
                    @keydown.down.prevent="openWithKeyboard = true"
                    class="rounded-full focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 dark:focus-visible:outline-blue-600"
                    aria-controls="userMenu">
                    <img src="https://penguinui.s3.amazonaws.com/component-assets/avatar-8.webp" alt="User Profile"
                        class="object-cover rounded-full size-10" />
                </button>
                <!-- User Dropdown -->
                <ul x-cloak x-show="userDropDownIsOpen || openWithKeyboard" x-transition.opacity
                    x-trap="openWithKeyboard" @click.outside="userDropDownIsOpen = false, openWithKeyboard = false"
                    @keydown.down.prevent="$focus.wrap().next()" @keydown.up.prevent="$focus.wrap().previous()"
                    id="userMenu"
                    class="absolute right-0 top-12 flex w-full min-w-[12rem] flex-col overflow-hidden rounded-xl border border-slate-300 bg-slate-100 py-1.5 dark:border-slate-700 dark:bg-slate-800">
                    <li class="border-b border-slate-300 dark:border-slate-700">
                        <div class="flex flex-col px-4 py-2">
                            <span class="text-sm font-medium text-black dark:text-white">Alice Brown</span>
                            <p class="text-xs text-slate-700 dark:text-slate-300">alice.brown@gmail.com</p>
                        </div>
                    </li>
                    <li><a href="#"
                            class="block px-4 py-2 text-sm bg-slate-100 text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white">Dashboard</a>
                    </li>
                    <li><a href="#"
                            class="block px-4 py-2 text-sm bg-slate-100 text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white">Subscription</a>
                    </li>
                    <li><a href="#"
                            class="block px-4 py-2 text-sm bg-slate-100 text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white">Settings</a>
                    </li>
                    <li><a href="#"
                            class="block px-4 py-2 text-sm bg-slate-100 text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white">Sign
                            Out</a></li>
                </ul>
            </li>
        </ul>
    </header>
    {{-- Sidenav for Desktop --}}
    <nav
        class="flex-col justify-between hidden px-3 pt-2 overflow-y-auto border-r-2 no-scrollbar xl:pt-5 xl:px-7 border-slate-300 dark:border-slate-700 sm:col-span-4 md:col-span-3 lg:col-span-2 sm:flex">
        <div class="space-y-4">
            <div class="space-y-1">
                <h5 class="px-2 font-bold uppercase text-slate-400 dark:text-slate-600">MENU</h5>
                <div class="space-y-1">
                    <a href="#"
                        class="w-full flex justify-between items-center [&>svg]:size-5 hover:bg-slate-100 dark:hover:bg-slate-800 px-2 py-1.5">
                        <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M14 21C13.4477 21 13 20.5523 13 20V12C13 11.4477 13.4477 11 14 11H20C20.5523 11 21 11.4477 21 12V20C21 20.5523 20.5523 21 20 21H14ZM4 13C3.44772 13 3 12.5523 3 12V4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V12C11 12.5523 10.5523 13 10 13H4ZM9 11V5H5V11H9ZM4 21C3.44772 21 3 20.5523 3 20V16C3 15.4477 3.44772 15 4 15H10C10.5523 15 11 15.4477 11 16V20C11 20.5523 10.5523 21 10 21H4ZM5 19H9V17H5V19ZM15 19H19V13H15V19ZM13 4C13 3.44772 13.4477 3 14 3H20C20.5523 3 21 3.44772 21 4V8C21 8.55228 20.5523 9 20 9H14C13.4477 9 13 8.55228 13 8V4ZM15 5V7H19V5H15Z">
                                </path>
                            </svg>
                            <span>Dashboard</span>
                        </div>
                    </a>
                    <div x-data="{
                        isExpanded: true,
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
                                class="pl-4 text-sm font-medium capitalize border-l-2 pointer-events-none text-rose-700 dark:text-rose-500 border-rose-700">
                                <a class="block py-2.5" href="#" disabled>Data Lelang</a>
                            </li>
                            <li
                                class="pl-4 text-sm font-medium capitalize border-l hover:text-black dark:hover:text-white hover:border-l-2 border-slate-300 dark:border-slate-700 dark:hover:border-slate-200 hover:border-slate-800">
                                <a class="block py-2.5" href="#">Nasabah</a>
                            </li>
                            <li
                                class="pl-4 text-sm font-medium capitalize border-l hover:text-black dark:hover:text-white hover:border-l-2 border-slate-300 dark:border-slate-700 dark:hover:border-slate-200 hover:border-slate-800">
                                <a class="block py-2.5" href="#">Motor</a>
                            </li>
                            <li
                                class="pl-4 text-sm font-medium capitalize border-l hover:text-black dark:hover:text-white hover:border-l-2 border-slate-300 dark:border-slate-700 dark:hover:border-slate-200 hover:border-slate-800">
                                <a class="block py-2.5 " href="#">Pembayaran Lelang</a>
                            </li>
                            <li
                                class="pl-4 text-sm font-medium capitalize border-l hover:text-black dark:hover:text-white hover:border-l-2 border-slate-300 dark:border-slate-700 dark:hover:border-slate-200 hover:border-slate-800">
                                <a class="block py-2.5 " href="#">Gallery</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
            <div class="space-y-1">
                <div class="flex items-center justify-between">
                    <h5 class="px-2 font-bold uppercase text-slate-400 dark:text-slate-600">USER</h5>
                    <button type="button" title="Tambah user"
                        class="[&>svg]:size-5 px-3 py-2 text-sm font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl  hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:focus-visible:outline-white">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M14 14.252V16.3414C13.3744 16.1203 12.7013 16 12 16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM18 17V14H20V17H23V19H20V22H18V19H15V17H18Z">
                            </path>
                        </svg> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-1">
                    <a href="#"
                        class="w-full flex justify-between items-center [&>svg]:size-5 hover:bg-slate-100 dark:hover:bg-slate-800 px-2 py-1.5">
                        <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z">
                                </path>
                            </svg>
                            <span>Data User</span>
                        </div>
                    </a>
                    <a href="#"
                        class="w-full flex justify-between items-center [&>svg]:size-5 hover:bg-slate-100 dark:hover:bg-slate-800 px-2 py-1.5">
                        <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M22.0049 6.99979H23.0049V16.9998H22.0049V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V6.99979ZM20.0049 16.9998H14.0049C11.2435 16.9998 9.00488 14.7612 9.00488 11.9998C9.00488 9.23836 11.2435 6.99979 14.0049 6.99979H20.0049V4.99979H4.00488V18.9998H20.0049V16.9998ZM21.0049 14.9998V8.99979H14.0049C12.348 8.99979 11.0049 10.3429 11.0049 11.9998C11.0049 13.6566 12.348 14.9998 14.0049 14.9998H21.0049ZM14.0049 10.9998H17.0049V12.9998H14.0049V10.9998Z">
                                </path>
                            </svg>
                            <span>Top-up Saldo</span>
                        </div>
                    </a>
                    <a href="#"
                        class="w-full flex justify-between items-center [&>svg]:size-5 hover:bg-slate-100 dark:hover:bg-slate-800 px-2 py-1.5">
                        <div class="flex gap-x-2 [&>svg]:size-5 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM6.00488 5.00275V9.00275C6.00488 12.3165 8.69117 15.0027 12.0049 15.0027C15.3186 15.0027 18.0049 12.3165 18.0049 9.00275V5.00275H6.00488ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z">
                                </path>
                            </svg>
                            <span>Pemenang Lelang</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div
            class="sticky bottom-0 flex justify-between py-2 transition-colors duration-300 bg-white border-t-2 border-slate-300 dark:bg-slate-900 dark:border-slate-700">
            <a href="#"
                class="[&>svg]:size-5 px-3 py-2 text-sm font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
                Sign Out
            </a>
            <a href="#"
                class="[&>svg]:size-5 px-3 py-2 text-sm font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
                Setting
            </a>
        </div>
    </nav>
    <nav
        class="absolute inset-x-0 bottom-0 flex justify-between transition-colors duration-300 bg-white border-t-2 sm:hidden border-slate-300 dark:bg-slate-900 dark:border-slate-700 xl:pb-5">
        <a href="#"
            class="[&>svg]:size-5 flex flex-col flex-1 justify-center gap-1 items-center py-2 text-blue-600 text-sm tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12.5812 2.68627C12.2335 2.43791 11.7664 2.43791 11.4187 2.68627L1.9187 9.47198L3.08118 11.0994L11.9999 4.7289L20.9187 11.0994L22.0812 9.47198L12.5812 2.68627ZM19.5812 12.6863L12.5812 7.68627C12.2335 7.43791 11.7664 7.43791 11.4187 7.68627L4.4187 12.6863C4.15591 12.874 3.99994 13.177 3.99994 13.5V20C3.99994 20.5523 4.44765 21 4.99994 21H18.9999C19.5522 21 19.9999 20.5523 19.9999 20V13.5C19.9999 13.177 19.844 12.874 19.5812 12.6863ZM5.99994 19V14.0146L11.9999 9.7289L17.9999 14.0146V19H5.99994Z">
                </path>
            </svg>
            <span>Beranda</span>
        </a>
        <a href="#"
            class="[&>svg]:size-5 flex flex-col flex-1 justify-center gap-1 items-center py-2 text-sm tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M14.0049 20.0028V22.0028H2.00488V20.0028H14.0049ZM14.5907 0.689087L22.3688 8.46726L20.9546 9.88147L19.894 9.52792L17.4191 12.0028L23.076 17.6597L21.6617 19.0739L16.0049 13.417L13.6007 15.8212L13.8836 16.9525L12.4693 18.3668L4.69117 10.5886L6.10539 9.17437L7.23676 9.45721L13.53 3.16396L13.1765 2.1033L14.5907 0.689087ZM15.2978 4.22462L8.22671 11.2957L11.7622 14.8312L18.8333 7.76015L15.2978 4.22462Z">
                </path>
            </svg>
            <span>Jelajahi</span>
        </a>
        <a href="#"
            class="[&>svg]:size-5 flex flex-col flex-1 justify-center gap-1 items-center py-2 text-sm tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M11 7H13V17H11V7ZM15 11H17V17H15V11ZM7 13H9V17H7V13ZM15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
                </path>
            </svg>
            <span>Laporan</span>
        </a>
        <a href="#"
            class="[&>svg]:size-5 flex flex-col flex-1 justify-center gap-1 items-center py-2 text-sm tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z">
                </path>
            </svg>
            <span>User</span>
        </a>
        <a href="#"
            class="[&>svg]:size-5 flex flex-col flex-1 justify-center gap-1 items-center py-2 text-sm tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M5.32943 3.27158C6.56252 2.8332 7.9923 3.10749 8.97927 4.09446C10.1002 5.21537 10.3019 6.90741 9.5843 8.23385L20.293 18.9437L18.8788 20.3579L8.16982 9.64875C6.84325 10.3669 5.15069 10.1654 4.02952 9.04421C3.04227 8.05696 2.7681 6.62665 3.20701 5.39332L5.44373 7.63C6.02952 8.21578 6.97927 8.21578 7.56505 7.63C8.15084 7.04421 8.15084 6.09446 7.56505 5.50868L5.32943 3.27158ZM15.6968 5.15512L18.8788 3.38736L20.293 4.80157L18.5252 7.98355L16.7574 8.3371L14.6361 10.4584L13.2219 9.04421L15.3432 6.92289L15.6968 5.15512ZM8.97927 13.2868L10.3935 14.7011L5.09018 20.0044C4.69966 20.3949 4.06649 20.3949 3.67597 20.0044C3.31334 19.6417 3.28744 19.0699 3.59826 18.6774L3.67597 18.5902L8.97927 13.2868Z">
                </path>
            </svg>
            <span>Pengaturan</span>
        </a>
    </nav>
    <main class="flex-1 mb-16 overflow-y-scroll sm:mb-0 no-scrollbar sm:col-span-8 md:col-span-9 lg:col-span-10">
        <p class="my-10">tinggi 1</p>
        <p class="my-10">tinggi 2</p>
        <p class="my-10">tinggi 3</p>
        <p class="my-10">tinggi 4</p>
        <p class="my-10">tinggi 5</p>
        <p class="my-10">tinggi 6</p>
        <p class="my-10">tinggi 7</p>
        <p class="my-10">tinggi 8</p>
        <p class="my-10">tinggi 9</p>
        <p class="my-10">tinggi 10</p>
        <p class="my-10">tinggi 11</p>
        <p class="my-10">tinggi 12</p>
        <p class="my-10">tinggi 13</p>
        <p class="my-10">tinggi 14</p>
        <p class="my-10">tinggi 15</p>
        <p class="my-10">tinggi 16</p>
        <p class="my-10">tinggi 17</p>
        <p class="my-10">tinggi 18</p>
        <p class="my-10">tinggi 19</p>
        <p class="my-10">tinggi 20</p>

    </main>





    @livewireScripts
</body>

</html>