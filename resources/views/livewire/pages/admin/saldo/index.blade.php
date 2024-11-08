<?php

use function Livewire\Volt\{state, title, updated, usesPagination, with};
use App\Models\TransaksiSaldoUser;

title('Transaksi Saldo');
usesPagination();

updated([
    'perPage' => fn () => $this->resetPage(),
    'search' => fn () => $this->resetPage(),
    'arus' => fn () => $this->resetPage(),
    'rentangNominal' => fn () => $this->resetPage(),
]);

state([
    'perPage' => 5,
    'search' => '',
    'arus' => '',
    'rentangNominal' => 0,
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

$validasi = function(TransaksiSaldoUser $transaksi){
    $transaksi->status = 'validated';
    $transaksi->id_validator = auth()->user()->id;
    $transaksi->validated_at = now();
    $transaksi->save();

    // mengoperasikan saldo user dengan nominal dari transaksi
    // jika arus adalah pemasukan, maka saldo user menjadi lebih besar
    if($transaksi->arus_transaksi === 'pemasukan'){
        $transaksi->user->saldo += $transaksi->nominal;
    }
    // jika arus adalah pengeluaran, maka saldo user menjadi kurang
    if($transaksi->arus_transaksi === 'pengeluaran'){
        $transaksi->user->saldo -= $transaksi->nominal;
    }
    $transaksi->user->save();

    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil validasi transaksi ' . $transaksi->user->name);
};

$reject = function(TransaksiSaldoUser $transaksi){
    $transaksi->status = 'rejected';
    $transaksi->id_validator = auth()->user()->id;
    $transaksi->validated_at = now();
    $transaksi->save();

    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil mereject transaksi ' . $transaksi->user->name);
};

with(fn () => ['transaksi_saldo_user' => TransaksiSaldoUser::with('user')->arusTransaksi($this->arus)->status('pending')->rentangNominal($this->rentangNominal)->search($this->search)->orderBy($this->sortBy, $this->sortOrder)->paginate($this->perPage)]);

?>

<div class="space-y-4 lg:space-y-8">
    <div class="flex items-center justify-between">
        <h1>Transaksi Saldo</h1>
        <a href="{{ route('admin.saldo.history') }}" wire:navigate
            class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-100 dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M19 22H5C3.34315 22 2 20.6569 2 19V3C2 2.44772 2.44772 2 3 2H17C17.5523 2 18 2.44772 18 3V15H22V19C22 20.6569 20.6569 22 19 22ZM18 17V19C18 19.5523 18.4477 20 19 20C19.5523 20 20 19.5523 20 19V17H18ZM16 20V4H4V19C4 19.5523 4.44772 20 5 20H16ZM6 7H14V9H6V7ZM6 11H14V13H6V11ZM6 15H11V17H6V15Z">
                </path>
            </svg>
            <span class="hidden md:block">History</span>
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
            <span class="hidden text-sm text-slate-700 dark:text-slate-300 sm:block">Nominal</span>
            <select wire:model.live="rentangNominal"
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
                    <th scope="col" class="p-4">User</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('keterangan')">Keterangan</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('arus_transaksi')">
                        Arus Transaksi
                    </th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('nominal')">Nominal</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('created_at')">Waktu</th>
                    <th scope="col" class="p-4" role="button">Bukti Transaksi</th>
                    <th scope="col" class="p-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                @foreach($transaksi_saldo_user as $transaksi)
                <tr wire:key="transaksi-{{ $transaksi->id }}">
                    <td class="p-4">
                        <div class="flex items-center gap-2 w-max">
                            <img class="object-cover rounded-full size-10"
                                src="{{ asset('storage/' .$transaksi->user->avatar) }}" alt="user avatar" />
                            <div class="flex flex-col">
                                <span class="text-black dark:text-white">{{ $transaksi->user->name }}</span>
                                <span class="text-sm text-slate-700 opacity-85 dark:text-slate-300">{{
                                    $transaksi->user->email
                                    }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">{{ $transaksi->keterangan }}</td>
                    <td class="p-4">
                        <span
                            class="inline-flex overflow-hidden rounded-xl border  px-2 py-0.5 text-xs font-medium {{ $transaksi->arus_transaksi === 'pemasukan' ? 'border-green-600 text-green-600 bg-green-600/10' : 'border-yellow-600 text-yellow-600 bg-yellow-600/10' }}">{{
                            $transaksi->arus_transaksi }}</span>

                    </td>
                    <td class="p-4">Rp. {{ $transaksi->nominal_ribuan }}</td>
                    <td class="p-4">{{ $transaksi->created_at->diffForHumans() }}</td>
                    <td class="p-4">
                        <a href="{{ asset('storage/' .$transaksi->bukti_transaksi) }}" target="_blank"
                            rel="noopener noreferrer">
                            <img src="{{ asset('storage/' .$transaksi->bukti_transaksi) }}" alt="bukti transaksi"
                                class="object-cover max-h-screen bg-slate-100 dark:bg-slate-800 size-16" />
                        </a>
                    </td>
                    <td class="p-4">
                        <button type="button" wire:click="validasi({{ $transaksi->id }})"
                            class="cursor-pointer whitespace-nowrap rounded-xl bg-transparent p-0.5 font-semibold text-green-700 outline-green-700 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-green-600 dark:outline-green-600">
                            Validate
                        </button>
                        <button type="button" wire:click="reject({{ $transaksi->id }})"
                            class="cursor-pointer whitespace-nowrap rounded-xl bg-transparent p-0.5 font-semibold text-red-700 outline-red-700 hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 dark:text-red-600 dark:outline-red-600">
                            Reject
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $transaksi_saldo_user->links() }}
</div>