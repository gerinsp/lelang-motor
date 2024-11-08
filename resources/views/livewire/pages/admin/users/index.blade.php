<?php

use function Livewire\Volt\{state, title, updated, usesPagination, with};
use App\Models\User;

title('Data User');
usesPagination();

updated([
    'perPage' => fn () => $this->resetPage(),
    'search' => fn () => $this->resetPage(),
    'status' => fn () => $this->resetPage(),
    'rentangSaldo' => fn () => $this->resetPage(),
]);

state([
    'perPage' => 5,
    'search' => '',
    'status' => 'all',
    'rentangSaldo' => 0,
    'sortBy' => 'created_at',
    'sortOrder' => 'desc',
])->url();

$setSortBy = function ($sortBy) {
    if($this->sortBy === $sortBy) {
        $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        return;
    }
    $this->sortBy = $sortBy;
    $this->sortOrder = 'desc';
};

with(fn () => ['users' => User::status($this->status)->rentangSaldo($this->rentangSaldo)->search($this->search)->orderBy($this->sortBy, $this->sortOrder)->paginate($this->perPage)]);

?>

<div class="space-y-4 lg:space-y-8">
    <div class="flex items-center justify-between">
        <h1>Users</h1>
        <a href="{{ route('admin.users.create') }}" wire:navigate
            class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-100 dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path>
            </svg>
            <span class="hidden md:block">Tambah User</span>
        </a>
    </div>
    <div class="flex flex-wrap items-center gap-1 sm:gap-2 md:gap-4">
        <div class="flex items-center gap-2">
            <span class="hidden text-sm text-slate-700 dark:text-slate-300 sm:block">Per Page</span>
            <select wire:model.live="perPage"
                class="border cursor-pointer rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:focus-visible:outline-rose-600">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <span class="hidden text-sm text-slate-700 dark:text-slate-300 sm:block">Status</span>
            <select wire:model.live="status"
                class="border cursor-pointer rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:focus-visible:outline-rose-600">
                <option value="all">All</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <span class="hidden text-sm text-slate-700 dark:text-slate-300 sm:block">Saldo</span>
            <select wire:model.live="rentangSaldo"
                class="border cursor-pointer rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:focus-visible:outline-rose-600">
                <option value="0">All</option>
                <option value="1">
                    < 500 rb</option>
                <option value="2">
                    500 rb - 1 jt </option>
                <option value="3">
                    1 - 2 jt </option>
                <option value="4">
                    2 - 5 jt </option>
                <option value="5">
                    5 - 10 jt </option>
                <option value="6">
                    > 10 jt </option>
            </select>
        </div>
        <div class="flex-1"></div>
        <div class="flex items-center flex-1 max-w-xl gap-2 min-w-44">
            <div class="relative flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" aria-hidden="true"
                    class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-slate-700/50 dark:text-slate-300/50">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input type="search" wire:model.live="search"
                    class="w-full py-2 pl-10 pr-2 text-sm border rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="search" placeholder="Search..." aria-label="search" />
            </div>
        </div>
    </div>
    <div class="w-full overflow-hidden overflow-x-auto border rounded-xl border-slate-300 dark:border-slate-700">
        <table class="w-full text-sm text-left text-slate-700 dark:text-slate-300">
            <thead
                class="text-sm text-black border-b border-slate-300 bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                <tr>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('name')">User</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('saldo')">Saldo</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('is_admin')">Status</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('created_at')">Waktu Join</th>
                    <th scope="col" class="p-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                @foreach($users as $user)
                <tr wire:key="user-{{ $user->id }}">
                    <td class="p-4">
                        <div class="flex items-center gap-2 w-max">
                            <img class="object-cover rounded-full size-10" src="{{ asset('storage/' .$user->avatar) }}"
                                alt="user avatar" />
                            <div class="flex flex-col">
                                <span class="text-black dark:text-white">{{ $user->name }}</span>
                                <span class="text-sm text-slate-700 opacity-85 dark:text-slate-300">{{ $user->email
                                    }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">Rp. {{ $user->saldo_ribuan }}</td>
                    <td class="p-4">
                        @if ($user->is_admin)
                        <span
                            class="inline-flex overflow-hidden rounded-xl border border-green-600 px-2 py-0.5 text-xs font-medium text-green-600 bg-green-600/10">Admin</span>
                        @else
                        <span
                            class="inline-flex overflow-hidden rounded-xl border border-slate-600 px-2 py-0.5 text-xs font-medium text-slate-600 bg-slate-600/10">User</span>
                        @endif
                    </td>
                    <td class="p-4">{{ $user->created_at->diffForHumans() }}</td>
                    <td class="p-4">
                        <a href="{{ route('admin.users.edit', $user->id) }}" wire:navigate
                            class="cursor-pointer whitespace-nowrap rounded-xl bg-transparent p-0.5 font-semibold text-yellow-700 outline-yellow-700 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-yellow-600 dark:outline-yellow-600">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
</div>