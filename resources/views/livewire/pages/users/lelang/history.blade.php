<?php

use function Livewire\Volt\{mount, state, title, updated, usesPagination, with};
use App\Models\User;

title('History Lelang');
usesPagination();


mount(function (?User $user) {
    // dd();
    // if(!$user->id){
    //     $user = User::find(auth()->user()->id);
    // }
    // if ($user->menangLelang->isEmpty()) {
    //     abort(404);
    // };
    // $this->user = $user;
});

updated([
    'perPage' => fn () => $this->resetPage(),
    'search' => fn () => $this->resetPage(),
    'statusPembayaran' => fn () => $this->resetPage(),
    'waktu_mulai_lelang' => fn () => $this->resetPage(),
]);


state([
    'user' => auth()->user(),
    'perPage' => 5,
    'search' => '',
    'waktu_mulai_lelang' => '',
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

with(fn () => ['riwayat_lelang' =>$this->user->pesertaLelang()->statusLelang('selesai')->search($this->search)->orderBy($this->sortBy, $this->sortOrder)->paginate($this->perPage)]);

?>

<div class="space-y-4 lg:space-y-8">
    <div class="flex items-center justify-between">
        <h1>Riwayat Lelang</h1>
        @if (auth()->user()->is_admin)
        <a href="{{ route('admin.pemenang.index') }}" wire:navigate
            class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-100 dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z">
                </path>
            </svg>
            <span class="hidden md:block">Kembali</span>
        </a>
        @endif
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
                    {{-- Motor, waktumulai, waktuselesai, harga awal, pemenang, penawaran akhir --}}
                    <th scope="col" class="p-4">Motor</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('waktu_mulai_lelang')">Waktu</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('harga_awal')">Harga Awal</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('penawaran_akhir')">Harga Akhir</th>
                    <th scope="col" class="p-4" role="button" wire:click="setSortBy('created_at')">Waktu</th>
                    <th scope="col" class="p-4">Kemenangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                @foreach($riwayat_lelang as $lelang)
                <tr wire:key="transaksi-{{ $lelang->id }}">
                    <td class="p-4">{{ $lelang->motor->nama }}</td>
                    <td class="p-4">{{ $lelang->waktu_mulai_lelang->diffForHumans() }}</td>
                    <td class="p-4">Rp. {{ $lelang->harga_awal_ribuan }}</td>
                    <td class="p-4">Rp. {{ $lelang->penawaran_akhir_ribuan }}</td>
                    <td class="p-4">{{ $lelang->created_at->diffForHumans() }}</td>
                    <td class="p-4">
                        @if ($lelang->id_pemenang === auth()->user()->id)
                        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM6.00488 5.00275V9.00275C6.00488 12.3165 8.69117 15.0027 12.0049 15.0027C15.3186 15.0027 18.0049 12.3165 18.0049 9.00275V5.00275H6.00488ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z">
                            </path>
                        </svg>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $riwayat_lelang->links() }}
</div>