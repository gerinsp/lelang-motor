<?php

use function Livewire\Volt\{state, title, updated, usesPagination, with};
use App\Models\Lelang;

title('Pemenang Lelang');
usesPagination();

updated([
    'perPage' => fn () => $this->resetPage(),
    'search' => fn () => $this->resetPage(),
    'statusPembayaran' => fn () => $this->resetPage(),
]);

state([
    'perPage' => 5,
    'search' => '',
    'statusPembayaran' => '',
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

with(fn () => ['pemenang_lelang' => Lelang::with(['motor', 'pemenang'])->statusLelang('selesai')->statusPembayaran($this->statusPembayaran)->search($this->search)->orderBy($this->sortBy, $this->sortOrder)->paginate($this->perPage)]);

?>

<div class="space-y-4 lg:space-y-8">
    <div class="flex items-center justify-between">
        <h1>Pemenang Lelang</h1>
        <a href="{{ route('admin.lelang.bayar') }}" wire:navigate
            class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-100 dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM20.0049 10.9998H4.00488V18.9998H20.0049V10.9998ZM20.0049 8.99979V4.99979H4.00488V8.99979H20.0049ZM14.0049 14.9998H18.0049V16.9998H14.0049V14.9998Z">
                </path>
            </svg>
            <span class="hidden md:block">Pembayaran</span>
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
            <span class="hidden text-sm text-slate-700 dark:text-slate-300 sm:block">Status Pembayaran</span>
            <select wire:model.live="statusPembayaran"
                class="border cursor-pointer rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:focus-visible:outline-rose-600">
                <option value="">All</option>
                <option value="pending">Belum Dibayar</option>
                <option value="validated">Lunas</option>
                <option value="rejected">Ditolak</option>
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
                    <th scope="col" class="p-4">Pemenang</th>
                    <th scope="col" class="p-4">Memenangkan</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('penawaran_akhir')">Harga</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('created_at')">Waktu</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('status_pembayaran')">
                        Status Pembayaran
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                @foreach($pemenang_lelang as $lelang)
                <tr wire:key="transaksi-{{ $lelang->id }}">
                    <td class="p-4">
                        <a href="{{ route('admin.pemenang.user', $lelang->pemenang->id) }}" wire:navigate
                            class="flex items-center gap-2 w-max">
                            <img class="object-cover rounded-full size-10"
                                src="{{ asset('storage/' .$lelang->pemenang->avatar) }}" alt="user avatar" />
                            <div class="flex flex-col">
                                <span class="text-black dark:text-white">{{ $lelang->pemenang->name }}</span>
                                <span class="text-sm text-slate-700 opacity-85 dark:text-slate-300">{{
                                    $lelang->pemenang->email
                                    }}</span>
                            </div>
                        </a>
                    </td>
                    <td class="p-4">{{ $lelang->motor->nama }}</td>
                    <td class="p-4">Rp. {{ $lelang->penawaran_akhir_ribuan }}</td>
                    <td class="p-4">{{ $lelang->created_at->diffForHumans() }}</td>
                    <td class="p-4">
                        <span class="inline-flex overflow-hidden rounded-xl border  px-2 py-0.5 text-xs font-medium
                            @if($lelang->status_pembayaran === 'pending')
                                border-yellow-600 text-yellow-600 bg-yellow-600/10
                            @elseif($lelang->status_pembayaran === 'validated')
                                border-green-600 text-green-600 bg-green-600/10
                            @elseif($lelang->status_pembayaran === 'rejected')
                                border-red-600 text-red-600 bg-red-600/10
                            @endif">
                            @if ($lelang->status_pembayaran === 'pending')
                            Pending
                            @elseif ($lelang->status_pembayaran === 'validated')
                            Lunas
                            @elseif ($lelang->status_pembayaran === 'rejected')
                            Ditolak
                            @endif
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $pemenang_lelang->links() }}
</div>