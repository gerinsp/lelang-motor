<?php
use function Livewire\Volt\{state};
Use App\Livewire\Actions\Logout;

$role = auth()->user()->is_admin ? 'admin' : 'users';

state([
    'role' => $role,
    'isAdmin' => auth()->user()->is_admin,
    
    // User Routes
    // 'isInUserLelangHistory' => request()->routeIs('users.lelang.history'),
    
    // Admin & User Routes
    'isInDashboard' => request()->routeIs($role . '.dashboard'),
    'isInLelang' => request()->routeIs($role . '.lelang.*') || request()->routeIs($role . '.pemenang.*'),
    'isInSaldo' => request()->routeIs($role . '.saldo.*'),
    'isInProfile' => request()->routeIs('profile'),
    'isInPemenang' => request()->routeIs($role . '.pemenang.*'),
    
    // Admin Routes
    'isInUsers' => request()->routeIs('admin.users.*') || request()->routeIs($role . '.saldo.*') || request()->routeIs('profile'),
]);

$logout = function (Logout $logout) {
    $logout();

    $this->redirectRoute('login', navigate: true);
};
?>

{{-- Bottom Navigation for mobile --}}
<nav class="absolute inset-x-0 bottom-0 z-50 flex justify-between bg-white border-t-2 border-slate-300 dark:text-slate-300 text-slate-700 sm:hidden dark:bg-slate-900 dark:border-slate-700 xl:pb-5"
    x-data="{
        activeSubMenu: null,
        setActiveSubMenu(subMenu) {
            if(subMenu === this.activeSubMenu) {
                this.activeSubMenu = null;
                return;
            }
            this.activeSubMenu = subMenu;
        },
    }" @click.outside="setActiveSubMenu(null)">
    <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('users.dashboard') }}" wire:navigate
        class="[&>svg]:size-5 flex flex-col flex-1 justify-center gap-1 items-center py-2 text-sm tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:focus-visible:outline-white {{ $isInDashboard ? 'text-rose-700 dark:text-rose-600' : 'text-slate-900 dark:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M12.5812 2.68627C12.2335 2.43791 11.7664 2.43791 11.4187 2.68627L1.9187 9.47198L3.08118 11.0994L11.9999 4.7289L20.9187 11.0994L22.0812 9.47198L12.5812 2.68627ZM19.5812 12.6863L12.5812 7.68627C12.2335 7.43791 11.7664 7.43791 11.4187 7.68627L4.4187 12.6863C4.15591 12.874 3.99994 13.177 3.99994 13.5V20C3.99994 20.5523 4.44765 21 4.99994 21H18.9999C19.5522 21 19.9999 20.5523 19.9999 20V13.5C19.9999 13.177 19.844 12.874 19.5812 12.6863ZM5.99994 19V14.0146L11.9999 9.7289L17.9999 14.0146V19H5.99994Z">
            </path>
        </svg>
        <span>Dashboard</span>
    </a>
    <button type="button" @click="setActiveSubMenu('lelang')"
        class="[&>svg]:size-5 flex flex-col flex-1 justify-center gap-1 items-center py-2 text-sm tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed  dark:focus-visible:outline-white {{ $isInLelang ? 'text-rose-700 dark:text-rose-600' : 'text-slate-900 dark:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M14.0049 20.0028V22.0028H2.00488V20.0028H14.0049ZM14.5907 0.689087L22.3688 8.46726L20.9546 9.88147L19.894 9.52792L17.4191 12.0028L23.076 17.6597L21.6617 19.0739L16.0049 13.417L13.6007 15.8212L13.8836 16.9525L12.4693 18.3668L4.69117 10.5886L6.10539 9.17437L7.23676 9.45721L13.53 3.16396L13.1765 2.1033L14.5907 0.689087ZM15.2978 4.22462L8.22671 11.2957L11.7622 14.8312L18.8333 7.76015L15.2978 4.22462Z">
            </path>
        </svg>
        <span>Lelang</span>
    </button>
    <a href="#"
        class="[&>svg]:size-5 flex flex-col flex-1 justify-center gap-1 items-center py-2 text-sm tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M11 7H13V17H11V7ZM15 11H17V17H15V11ZM7 13H9V17H7V13ZM15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918Z">
            </path>
        </svg>
        <span>Laporan</span>
    </a>
    <button type="button" @click="setActiveSubMenu('users')"
        class="[&>svg]:size-5 flex flex-col flex-1 justify-center gap-1 items-center py-2 text-sm tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl  hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:focus-visible:outline-white {{ $isInUsers ? 'text-rose-700 dark:text-rose-600' :  'text-slate-900 dark:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z">
            </path>
        </svg>
        <span>User</span>
    </button>
    <div x-cloak x-show="activeSubMenu === 'lelang'" x-transition:enter="transition transform duration-300"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition transform duration-300" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="[&>a]:py-2 [&>a]:px-3 absolute inset-x-0 flex items-center bg-white dark:bg-slate-900 border-y border-slate-300 dark:border-slate-700 bottom-full overflow-x-auto">
        @if ($isAdmin)
        <a href="{{ route('admin.lelang.create') }}" wire:navigate
            class="[&>svg]:size-5 border-r text-center active:outline outline-slate-300 dark:outline-slate-700 border-slate-300 dark:border-slate-700 text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 active:opacity-100 active:outline-offset-0 dark:text-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path>
            </svg>
        </a>
        @endif

        <a href="{{ route($role . '.lelang.index') }}" wire:navigate
            class="active:outline outline-slate-300 dark:outline-slate-700 border-slate-300 dark:border-slate-700 text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 active:opacity-100 active:outline-offset-0 dark:text-slate-100">Lelang</a>
        <a href="{{ route($role .'.lelang.bayar') }}" wire:navigate
            class="active:outline outline-slate-300 dark:outline-slate-700 border-slate-300 dark:border-slate-700 text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 active:opacity-100 active:outline-offset-0 dark:text-slate-100">Pembayaran</a>
        @if ($isAdmin)
        <a href="{{ route('admin.lelang.nasabah') }}" wire:navigate
            class="active:outline outline-slate-300 dark:outline-slate-700 border-slate-300 dark:border-slate-700 text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 active:opacity-100 active:outline-offset-0 dark:text-slate-100">Nasabah</a>
        @endif
        <a href="{{ route($role .'.pemenang.index') }}" wire:navigate
            class="active:outline outline-slate-300 dark:outline-slate-700 border-slate-300 dark:border-slate-700 text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 active:opacity-100 active:outline-offset-0 dark:text-slate-100">Pemenang</a>
    </div>
    <div x-cloak x-show="activeSubMenu === 'users'" x-transition:enter="transition transform duration-300"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition transform duration-300" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="[&>a]:py-2 [&>a]:px-3 absolute inset-x-0 flex items-center bg-white dark:bg-slate-900 border-y border-slate-300 dark:border-slate-700 bottom-full overflow-x-auto">
        @if ($isAdmin)
        <a href="{{ route('admin.users.create') }}" wire:navigate
            class="[&>svg]:size-5 border-r text-center active:outline outline-slate-300 dark:outline-slate-700 border-slate-300 dark:border-slate-700 text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 active:opacity-100 active:outline-offset-0 dark:text-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path>
            </svg>
        </a>
        <a href="{{ route('admin.users.index') }}" wire:navigate
            class="active:outline outline-slate-300 dark:outline-slate-700 border-slate-300 dark:border-slate-700 text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 active:opacity-100 active:outline-offset-0 dark:text-slate-100">Users</a>
        @endif
        <a href="{{ route($role . '.saldo.index') }}" wire:navigate
            class="active:outline outline-slate-300 dark:outline-slate-700 border-slate-300 dark:border-slate-700 text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 active:opacity-100 active:outline-offset-0 dark:text-slate-100">Saldo</a>
        <a href="{{ route('profile') }}" wire:navigate
            class="active:outline outline-slate-300 dark:outline-slate-700 border-slate-300 dark:border-slate-700 text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 active:opacity-100 active:outline-offset-0 dark:text-slate-100">Profile</a>
    </div>
</nav>