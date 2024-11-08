<?php
use App\Models\TransaksiSaldoUser;
use App\Livewire\Forms\TopupForm;
use function Livewire\Volt\{form, mount, state, title, usesFileUploads};

title(fn() => ucfirst($this->page) . ' ' . 'Transaksi Saldo');
usesFileUploads();

form(TopupForm::class);

mount(function(?TransaksiSaldoUser $topup) {
    if(request()->routeIs('users.saldo.topup')){
        $this->page = 'create';
    } elseif (request()->routeIs('users.saldo.topup.edit')) {
        $this->page = 'edit';
    }
    $this->form->setData($topup);
});

state('page');

$save = function () {
    if($this->page === 'create'){
        $this->store();
    } else {
        $this->update();
    }};

$store = function () {
    $this->form->store();
    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil menambahkan transaksi');

    // return $this->redirectRoute('admin.users.index', navigate: true);
};

$update = function () {
    $this->form->update();
    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil memperbarui transaksi');

    // return $this->redirectRoute('admin.users.index', navigate: true);
};


$clear = function () {
    $this->form->reset();
    $this->resetValidation();
    if($this->page === 'edit'){
        $this->dispatch('notify', variant: 'warning', title: 'Hati-hati', message: 'Inputan yang dibersihkan akan memperbarui semua data user saat ini');
    }
    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil membersihkan inputan');
}
?>

<div class="space-y-4 lg:space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="capitalize">{{ $page }} Topup</h1>
        <a href="{{ route('users.saldo.index') }}" wire:navigate
            class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-300 dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z">
                </path>
            </svg>
            <span class="hidden md:block">Kembali</span>
        </a>
    </div>
    <form wire:submit="save" class="flex flex-col max-w-lg gap-2 md:gap-4">
        <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
            <label for="keterangan" class="w-fit pl-0.5 text-sm sm:text-base ">Keterangan</label>
            <input id="keterangan" type="text"
                class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                name="keterangan" placeholder="Enter your keterangan" wire:model.blur="form.keterangan" />
            @error('form.keterangan') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
        </div>
        {{-- <div class="flex flex-col justify-between gap-x-2">
            <label for="arus_transaksi" class="w-fit pl-0.5 text-sm sm:text-base">Arus Transaksi<sup
                    class="text-rose-700 dark:text-rose-600">*</sup></label>
            <div class="flex gap-2">
                <label for="arus_transaksi"
                    class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                    <input id="arus_transaksi" type="radio"
                        class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                        name="arus_transaksi" value="pengeluaran" wire:model.blur="form.arus_transaksi">
                    <span class="text-sm sm:text-base">Pengeluaran</span>
                </label>
                <label for="x_arus_transaksi"
                    class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                    <input id="x_arus_transaksi" type="radio"
                        class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                        name="arus_transaksi" value="pemasukan" wire:model.blur="form.arus_transaksi">
                    <span class="text-sm sm:text-base">Pemasukan</span>
                </label>
            </div>
            @error('form.arus_transaksi') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
        </div> --}}
        <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
            <label for="nominal" class="w-fit pl-0.5 text-sm sm:text-base ">Nominal</label>
            <input id="nominal" type="number" wire:model.blur="form.nominal"
                class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl focus:ring-0 border-slate-300 bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                name="nominal" placeholder="Masukkan nominal" />
            @error('form.nominal') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
        </div>

        <div class="relative flex flex-col w-full gap-1">
            <label class="w-fit pl-0.5 text-sm text-slate-700 dark:text-slate-300" for="bukti_transaksi">Upload
                File</label>
            <input id="bukti_transaksi" type="file" wire:model.blur="form.bukti_transaksi" accept="image/*"
                class="w-full text-sm border overflow-clip rounded-xl border-slate-300 focus:ring-0 bg-slate-100/50 text-slate-700 file:mr-4 file:cursor-pointer file:border-none file:bg-slate-100 file:px-4 file:py-2 file:font-medium file:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-300 dark:file:bg-slate-800 dark:file:text-white dark:focus-visible:outline-rose-600" />
            @error('form.bukti_transaksi') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
        </div>
        <div class="flex items-center justify-end gap-x-2">
            <div class="flex-1"></div>
            @if (isset($form->topup->bukti_transaksi) && $form->topup->bukti_transaksi === $form->bukti_transaksi)
            <img src="{{ asset('storage/' .$form->topup->bukti_transaksi) }}" alt="bukti_transaksi"
                class="w-16 h-16 rounded-full" />
            @elseif ($form->bukti_transaksi)
            <img src="{{ asset($form->bukti_transaksi->temporaryUrl()) }}" alt="bukti_transaksi"
                class="w-16 h-16 rounded-full" />
            @else
            <idv class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 outline outline-1 outline-slate-300 dark:outline-slate-700"
                wire:loading.class="animate-pulse" />
            @endif
        </div>

        <div class="flex justify-between gap-2">
            @if ($page === 'create')
            <button type="button" wire:click="clear"
                class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline  dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white">
                <span>Clear</span>
            </button>
            @endif
            <div class="flex-1"></div>
            <button type="submit" wire:loading.attr="disabled"
                class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-white dark:focus-visible:outline-white outline">
                <span>Submit</span>
            </button>
        </div>
    </form>
</div>