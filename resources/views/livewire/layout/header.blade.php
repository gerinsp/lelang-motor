<?php

Use App\Livewire\Actions\Logout;
use function Livewire\Volt\{state};

state([
    'isInHomeOrAdminDashboard' => request()->routeIs('admin.dashboard') || request()->routeIs('home'),
    'isAdmin' => auth()->user()->is_admin,
]);

$logout = function (Logout $logout) {
    $logout();

    $this->redirectRoute('login', navigate: true);
};

?>

<header
    class="flex items-center justify-between gap-4 px-6 py-4 border-b sm:col-span-full bg-slate-100 dark:bg-slate-800 border-slate-300 dark:border-slate-700"
    aria-label="penguin ui menu">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" wire:navigate class="text-2xl font-bold text-black dark:text-white">
        <span>Lelang <span class="text-rose-700 dark:text-rose-600">Kertamulia</span></span>
        <!-- <img src="./your-logo.svg" alt="brand logo" class="w-10" /> -->
    </a>

    <!-- Desktop Menu -->
    <div class="flex items-center gap-x-4">
        <ul class="items-center hidden sm:flex gap-x-4">
            <li>
                <button type="button" title="Jelajahi lelang"
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
                    <svg x-cloak x-show="!isDark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M10 7C10 10.866 13.134 14 17 14C18.9584 14 20.729 13.1957 21.9995 11.8995C22 11.933 22 11.9665 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C12.0335 2 12.067 2 12.1005 2.00049C10.8043 3.27098 10 5.04157 10 7ZM4 12C4 16.4183 7.58172 20 12 20C15.0583 20 17.7158 18.2839 19.062 15.7621C18.3945 15.9187 17.7035 16 17 16C12.0294 16 8 11.9706 8 7C8 6.29648 8.08133 5.60547 8.2379 4.938C5.71611 6.28423 4 8.9417 4 12Z">
                        </path>
                    </svg>
                    <svg x-cloak x-show="isDark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M12 18C8.68629 18 6 15.3137 6 12C6 8.68629 8.68629 6 12 6C15.3137 6 18 8.68629 18 12C18 15.3137 15.3137 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16ZM11 1H13V4H11V1ZM11 20H13V23H11V20ZM3.51472 4.92893L4.92893 3.51472L7.05025 5.63604L5.63604 7.05025L3.51472 4.92893ZM16.9497 18.364L18.364 16.9497L20.4853 19.0711L19.0711 20.4853L16.9497 18.364ZM19.0711 3.51472L20.4853 4.92893L18.364 7.05025L16.9497 5.63604L19.0711 3.51472ZM5.63604 16.9497L7.05025 18.364L4.92893 20.4853L3.51472 19.0711L5.63604 16.9497ZM23 11V13H20V11H23ZM4 11V13H1V11H4Z">
                        </path>
                    </svg>
                </button>
            </li>
            <!-- User Pic -->
        </ul>
        <div x-data="{ userDropDownIsOpen: false, openWithKeyboard: false }"
            @keydown.esc.window="userDropDownIsOpen = false, openWithKeyboard = false"
            class="relative flex items-center">
            <button @click="userDropDownIsOpen = ! userDropDownIsOpen" :aria-expanded="userDropDownIsOpen"
                @keydown.space.prevent="openWithKeyboard = true" @keydown.enter.prevent="openWithKeyboard = true"
                @keydown.down.prevent="openWithKeyboard = true"
                class="rounded-full focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 dark:focus-visible:outline-rose-600"
                aria-controls="userMenu">
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="User Profile"
                    class="object-cover rounded-full size-10" />
            </button>
            <!-- User Dropdown -->
            <ul x-cloak x-show="userDropDownIsOpen || openWithKeyboard" x-transition.opacity x-trap="openWithKeyboard"
                @click.outside="userDropDownIsOpen = false, openWithKeyboard = false"
                @keydown.down.prevent="$focus.wrap().next()" @keydown.up.prevent="$focus.wrap().previous()"
                id="userMenu"
                class="z-50 absolute right-0 top-12 flex w-full min-w-[12rem] flex-col overflow-hidden rounded-xl border border-slate-300 bg-slate-100 py-1.5 dark:border-slate-700 dark:bg-slate-800">
                <li class="border-b border-slate-300 dark:border-slate-700">
                    <div class="flex flex-col px-4 py-2">
                        <span class="text-sm font-medium text-black dark:text-white">
                            {{ auth()->user()->name}}
                        </span>
                        <p class="text-xs text-slate-700 dark:text-slate-300">{{ auth()->user()->email }}</p>
                    </div>
                </li>
                <li>
                    <a href="{{ $isAdmin ? route('admin.dashboard') : route('users.dashboard') }}" wire:navigate class="block px-4 py-2 text-sm  text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none  dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white
                        {{ $isInHomeOrAdminDashboard ? 'bg-slate-800/5 dark:bg-slate-100/5 pointer-events-none' : 'bg-slate-100 dark:bg-slate-800' }}
                        ">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile') }}" wire:navigate
                        class="block px-4 py-2 text-sm bg-slate-100 text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white">
                        Profile
                    </a>
                </li>
                <li>
                    <a href="#" wire:click="logout"
                        class="block px-4 py-2 text-sm bg-slate-100 text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white">
                        Sign Out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>