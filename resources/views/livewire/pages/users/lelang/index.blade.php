<?php

use function Livewire\Volt\{state, title, updated, usesPagination, with};
use App\Models\Lelang;

title('Data Lelang');
usesPagination();

updated([
    'perPage' => fn () => $this->resetPage(),
    'search' => fn () => $this->resetPage(),
    'waktuLelang' => fn () => $this->resetPage(),
]);

state([
    'perPage' => 8,
    'search' => '',
    'waktuLelang' => 'all',
    'sortBy' => 'waktu_mulai_lelang',
    'sortOrder' => 'asc',
])->url();

$setSortBy = function ($sortBy) {
    if($this->sortBy === $sortBy) {
        $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        return;
    }
    $this->sortBy = $sortBy;
    $this->sortOrder = 'desc';
};

with(fn () => ['lelang_lelang' => Lelang::statusLelang('akan datang')->waktuLelang($this->waktuLelang)->with('motor.nasabah')->search($this->search)->orderBy($this->sortBy, $this->sortOrder)->paginate($this->perPage)]);

?>

<div class="space-y-4 lg:space-y-8">
    <div class="flex items-center justify-between" id="lelang-title">
        <h1>Lelang</h1>
    </div>
    <div class="flex flex-wrap items-center gap-1 sm:gap-2 md:gap-4">
        <div class="flex items-center gap-2">
            <span class="hidden text-sm text-slate-700 dark:text-slate-300 sm:block">Per Page</span>
            <select wire:model.live="perPage"
                class="border cursor-pointer rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:focus-visible:outline-rose-600">
                <option value="4">4</option>
                <option value="8">8</option>
                <option value="10">10</option>
                <option value="12">12</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <span class="hidden text-sm text-slate-700 dark:text-slate-300 sm:block">Waktu</span>
            <select wire:model.live="waktuLelang"
                class="border cursor-pointer rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:focus-visible:outline-rose-600">
                <option value="all">All</option>
                <option value="today">Hari Ini</option>
                <option value="tomorrow">Hari Berikutnya</option>
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
    <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4 xl:grid-cols-3 2xl:grid-cols-4">
        @foreach ($lelang_lelang as $lelang)
        <x-card-lelang :lelang="$lelang"></x-card-lelang>
        @endforeach
    </div>
    {{-- <div class="w-full overflow-hidden overflow-x-auto border rounded-xl border-slate-300 dark:border-slate-700">
        <table class="w-full text-sm text-left text-slate-700 dark:text-slate-300">
            <thead
                class="text-sm text-black border-b border-slate-300 bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                <tr>
                    <th scope="col" class="p-4">Nasabah</th>
                    <th scope="col" class="p-4">Motor</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('waktu_mulai_lelang')">Waktu Lelang
                    </th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('status_lelang')">Status Lelang</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('keterangan')">Keterangan</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('harga_awal')">Harga Awal</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('uang_jaminan')">Uang jaminan</th>
                    <th scope="col" class="p-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                @foreach($lelang_lelang as $lelang)
                <tr wire:key="user-{{ $lelang->id }}">
                    <td class="p-4">{{ $lelang->motor->nasabah->nama }}</td>
                    <td class="p-4">{{ $lelang->motor->nama }}</td>
                    <td class="p-4">{{ $lelang->waktu_mulai_lelang }}</td>
                    <td class="p-4">
                        <span class="inline-flex overflow-hidden rounded-xl border  px-2 py-0.5 text-xs font-medium
                            @if($lelang->status_lelang === 'berlangsung')
                                border-red-600 text-red-600 bg-red-600/10
                            @elseif($lelang->status_lelang === 'akan datang')
                                border-green-600 text-green-600 bg-green-600/10
                            @endif">
                            @if ($lelang->status_lelang === 'berlangsung')
                            Berlangsung
                            @elseif ($lelang->status_lelang === 'akan datang')
                            Akan Datang
                            @endif
                        </span>
                    </td>
                    <td class="p-4">{{ $lelang->keterangan }}</td>
                    <td class="p-4">Rp. {{ $lelang->harga_awal_ribuan }}</td>
                    <td class="p-4">Rp. {{ $lelang->uang_jaminan_ribuan }}</td>
                    <td class="p-4">
                        <a href="{{ route('admin.lelang.edit', $lelang->id) }}" wire:navigate
                            class="cursor-pointer whitespace-nowrap rounded-xl bg-transparent p-0.5 font-semibold text-yellow-700 outline-yellow-700 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-yellow-600 dark:outline-yellow-600">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}
    {{ $lelang_lelang->links(data: ['scrollTo' => '#lelang-title']) }}
</div>