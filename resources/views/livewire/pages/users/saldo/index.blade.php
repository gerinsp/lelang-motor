<?php

use function Livewire\Volt\{state, title, updated, usesPagination, with};
use App\Models\TransaksiSaldoUser;

title('Riwayat Transaksi Saldo');
usesPagination();

updated([
    'perPage' => fn () => $this->resetPage(),
    'search' => fn () => $this->resetPage(),
    'status' => fn () => $this->resetPage(),
    'arus' => fn () => $this->resetPage(),
]);

state([
    'perPage' => 5,
    'search' => '',
    'status' => 'all',
    'arus' => '',
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

$update = function($id){
    dd($id);
};

with(fn () => ['transaksi_saldo_user' => TransaksiSaldoUser::where('id_user', auth()->user()->id)->with(['user', 'validator'])->arusTransaksi($this->arus)->status($this->status)->search($this->search)->orderBy($this->sortBy, $this->sortOrder)->paginate($this->perPage)]);

?>

<div class="space-y-4 lg:space-y-8">
    <div class="flex items-center justify-between">
        <h1>Riwayat Transaksi Saldo</h1>
        <a href="{{ route('users.saldo.topup') }}" wire:navigate
            class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-100 dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path>
            </svg>
            <span class="hidden md:block">Topup Saldo</span>
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
            <span class="hidden text-sm text-slate-700 dark:text-slate-300 sm:block">Arus</span>
            <select wire:model.live="arus"
                class="border cursor-pointer rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:focus-visible:outline-rose-600">
                <option value="">All</option>
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <span class="hidden text-sm text-slate-700 dark:text-slate-300 sm:block">Status</span>
            <select wire:model.live="status"
                class="border cursor-pointer rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:focus-visible:outline-rose-600">
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="validated">Validated</option>
                <option value="rejected">Rejected</option>
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
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('keterangan')">Keterangan</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('arus_transaksi')">
                        Arus Transaksi
                    </th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('nominal')">Nominal</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('created_at')">Waktu</th>
                    <th scope="col" class="p-4">Bukti Transaksi</th>
                    <th scope="col" class="p-4">Status</th>
                    <th scope="col" class="p-4">Validator</th>
                    <th scope="col" class="p-4">Validated At</th>
                    @if ($status === 'all' || $status === 'pending')
                    <th scope="col" class="p-4"></th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                @foreach($transaksi_saldo_user as $transaksi)
                <tr wire:key="transaksi-{{ $transaksi->id }}">
                    <td class="p-4">{{ $transaksi->keterangan }}</td>
                    <td class="p-4">
                        <span
                            class="inline-flex overflow-hidden rounded-xl border  px-2 py-0.5 text-xs font-medium {{ $transaksi->arus_transaksi === 'pemasukan' ? 'border-green-600 text-green-600 bg-green-600/10' : 'border-yellow-600 text-yellow-600 bg-yellow-600/10' }}">{{
                            $transaksi->arus_transaksi }}
                        </span>
                    </td>
                    <td class="p-4">Rp. {{ $transaksi->nominal_ribuan }}</td>
                    <td class="p-4">{{ $transaksi->created_at }}</td>
                    <td class="p-4">
                        <a href="{{ asset('storage/' .$transaksi->bukti_transaksi) }}" target="_blank"
                            rel="noopener noreferrer">
                            <img src="{{ asset('storage/' .$transaksi->bukti_transaksi) }}" alt="bukti transaksi"
                                class="object-cover max-h-screen bg-slate-100 dark:bg-slate-800 size-16" />
                        </a>
                    </td>
                    <td class="p-4">
                        <span
                            class="inline-flex overflow-hidden rounded-xl border  px-2 py-0.5 text-xs font-medium {{ $transaksi->status === 'validated' ? 'border-green-600 text-green-600 bg-green-600/10' : 'border-red-600 text-red-600 bg-red-600/10' }}">{{
                            $transaksi->status }}
                        </span>
                    </td>
                    <td class="p-4">{{ $transaksi->validator?->name }}</td>
                    <td class="p-4">{{ $transaksi->validated_at?->diffForHumans() }}</td>
                    <td class="p-4">
                        @if ($status === 'all' || $status === 'pending')
                        @if ($transaksi->status === 'rejected')
                        <a href="{{ route('users.saldo.topup.edit', $transaksi->id) }}" wire:navigate
                            class="cursor-pointer whitespace-nowrap rounded-xl bg-transparent p-0.5 font-semibold text-green-700 outline-green-700 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-green-600 dark:outline-green-600">
                            Update
                        </a>
                        @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $transaksi_saldo_user->links() }}
</div>