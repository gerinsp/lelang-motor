<?php

use function Livewire\Volt\{state, title, updated, usesPagination, with};
use App\Models\Lelang;

title('Pembayaran Lelang');
usesPagination();

updated([
    'perPage' => fn () => $this->resetPage(),
    'search' => fn () => $this->resetPage(),
    'penawaran_akhir' => fn () => $this->resetPage(),
]);

state([
    'perPage' => 5,
    'search' => '',
    'penawaran_akhir' => 0,
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

$validasi = function(Lelang $lelang){
    $lelang->status_pembayaran = 'validated';
    $lelang->id_validator = auth()->user()->id;
    $lelang->validated_at = now();
    $lelang->save();

    // Update Nasabah hapus_buku, kredit_lunas

    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil validasi pembayaran lelang ' . $lelang->pemenang->name);
};

$reject = function(Lelang $lelang){
    $lelang->status_pembayaran = 'rejected';
    $lelang->id_validator = auth()->user()->id;
    $lelang->validated_at = now();
    $lelang->save();

    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil mereject pembayaran lelang ' . $lelang->pemenang->name);
};

with(fn () => ['tagihan_lelang' => Lelang::whereTagihanLelang()->with(['pemenang', 'motor'])->penawaranAkhir($this->penawaran_akhir)->search($this->search)->orderBy($this->sortBy, $this->sortOrder)->paginate($this->perPage)]);

?>

<div class="space-y-4 lg:space-y-8">
    <div class="flex items-center justify-between">
        <h1>Pembayaran Lelang</h1>
        <a href="{{ route('admin.lelang.index') }}" wire:navigate
            class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-100 dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z">
                </path>
            </svg>
            <span class="hidden md:block">Kembali</span>
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
            <span class="hidden text-sm text-slate-700 dark:text-slate-300 sm:block">Tagihan</span>
            <select wire:model.live="penawaran_akhir"
                class="border cursor-pointer rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:focus-visible:outline-rose-600">
                <option value="0">All</option>
                <option value="1">
                    < 1 jt</option>
                <option value="2">
                    1 - 2 jt </option>
                <option value="3">
                    2 - 5 jt </option>
                <option value="4">
                    5 - 10 jt </option>
                <option value="5">
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
                    <th scope="col" class="p-4">User</th>
                    <th scope="col" class="p-4">Motor</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('penawaran_akhir')">Tagihan</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('created_at')">Waktu</th>
                    <th scope="col" class="p-4">Bukti Transaksi</th>
                    <th scope="col" class="p-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                @foreach($tagihan_lelang as $lelang)
                <tr wire:key="lelang-{{ $lelang->id }}">
                    <td class="p-4">
                        <div class="flex items-center gap-2 w-max">
                            <img class="object-cover rounded-full size-10"
                                src="{{ asset('storage/' .$lelang->pemenang->avatar) }}" alt="pemenang avatar" />
                            <div class="flex flex-col">
                                <span class="text-black dark:text-white">{{ $lelang->pemenang->name }}</span>
                                <span class="text-sm text-slate-700 opacity-85 dark:text-slate-300">{{
                                    $lelang->pemenang->email
                                    }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">{{ $lelang->motor->nama }}</td>
                    <td class="p-4">Rp. {{ $lelang->penawaran_akhir_ribuan }}</td>
                    <td class="p-4">{{ $lelang->created_at}}</td>
                    <td class="p-4">
                        <a href="{{ asset('storage/' .$lelang->bukti_pembayaran) }}" target="_blank"
                            rel="noopener noreferrer">
                            <img src="{{ asset('storage/' .$lelang->bukti_pembayaran) }}" alt="bukti lelang"
                                class="object-cover max-h-screen bg-slate-100 dark:bg-slate-800 size-16" />
                        </a>
                    </td>
                    <td class="p-4">
                        <button type="button" wire:click="validasi({{ $lelang->id }})"
                            class="cursor-pointer whitespace-nowrap rounded-xl bg-transparent p-0.5 font-semibold text-green-700 outline-green-700 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-green-600 dark:outline-green-600">
                            Validate
                        </button>
                        <button type="button" wire:click="reject({{ $lelang->id }})"
                            class="cursor-pointer whitespace-nowrap rounded-xl bg-transparent p-0.5 font-semibold text-red-700 outline-red-700 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-red-600 dark:outline-red-600">
                            Reject
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $tagihan_lelang->links() }}
</div>