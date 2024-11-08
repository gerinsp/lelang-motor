<?php
use App\Models\Lelang;
use App\Livewire\Forms\LelangForm;
use function Livewire\Volt\{form, mount, state, title, usesFileUploads, with};

title(fn() => ucfirst($this->page) . ' ' . 'Lelang');
usesFileUploads();

form(LelangForm::class);

mount(function(?Lelang $lelang) {
    if(request()->routeIs('admin.lelang.create')){
        $this->page = 'create';
    } elseif (request()->routeIs('admin.lelang.edit')) {
        $this->page = 'edit';
    }
    $this->form->setData($lelang);
});

state(['page', 'currentStep' => 1]);

$save = function () {
    if($this->page === 'create'){
        $this->store();
    } else {
        $this->update();
    }
};

$store = function () {
    $this->form->store();
    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil menambahkan lelang ' . $this->form->motor['nama']);
};

$update = function () {
    $this->form->update();
    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil memperbarui lelang ' . $this->form->motor['nama']);
};


$clear = function () {
    $this->form->reset();
    $this->resetValidation();
    if($this->page === 'edit'){
        $this->dispatch('notify', variant: 'warning', title: 'Hati-hati', message: 'Inputan yang dibersihkan akan memperbarui semua data saat ini');
    }
    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil membersihkan inputan');
};

$previousStep = function () {
    $this->currentStep--;
};

$nextStep = function () {
    if($this->currentStep === 1){
        $this->form->validateMotor();
    }
    if($this->currentStep === 2){
        $this->form->validateFotoMotor();
    }
    if($this->currentStep === 3){
        $this->form->validateNasabah();
    }
    if($this->currentStep === 4){
        $this->form->validateLelang();
        return $this->save();
    }
    $this->currentStep++;
};

$removeFotoMotor = function ($index) {
    unset($this->form->foto_motor[$index]);
};

?>

<div class="space-y-4 lg:space-y-8" x-data="
    {
        currentStep: @entangle('currentStep'),
        steps: [
            { title: 'Motor' },
            { title: 'Foto Motor' },
            { title: 'Nasabah' },
            { title: 'Lelang' },
        ],
        isCompleted(index) {
            return this.currentStep > index+1;
        },
        isCurrent(index) {
            return this.currentStep === index+1;
        },
        isDisabled(index) {
            return this.currentStep < index+1;
        },
        nextStep() {
            $wire.nextStep();
        },
        previousStep() {
            if (this.currentStep > 1) {
                $wire.previousStep();
            }
        },
    }">
    <div class="flex items-center justify-between">
        <h1 class="capitalize">Form</h1>
        <a href="{{ route('admin.lelang.index') }}" wire:navigate
            class="[&>svg]:size-6 inline-flex gap-x-2 items-center px-3 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-300 dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z">
                </path>
            </svg>
            <span class="hidden md:block">Kembali</span>
        </a>
    </div>
    <ol class="flex items-center w-full gap-2" aria-label="registration progress">
        <template x-for="(step, index) in steps" :key="index">
            <li class="text-sm" x-bind:aria-label="step.title" x-bind:class="{
                'flex w-full items-center': index !== 0,
            }">
                <template x-if="index !== 0">
                    <span class="h-0.5 w-full" aria-hidden="true" x-bind:class="{
                            'bg-rose-700 dark:bg-rose-600': isCurrent(index) || isCompleted(index),
                            'bg-slate-300 dark:bg-slate-700': isDisabled(index)
                        }"></span>
                </template>
                <div class="flex items-center gap-2" x-bind:class="{ 'pl-2': !isCompleted(index) }">
                    <span class="flex items-center justify-center border rounded-full size-6" x-bind:class="{
                            'border-rose-700 bg-rose-700 text-slate-100 dark:border-rose-600 dark:bg-rose-600 dark:text-slate-100': isCompleted(index) || isCurrent(index),
                            'font-medium border-slate-300 bg-slate-100 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300': isDisabled(index),
                            'font-bold outline outline-2 outline-offset-2 outline-rose-700 dark:outline-rose-600': isCurrent(index),
                            'flex-shrink-0': isCurrent(index) || isDisabled(index)
                        }">
                        <template x-if="isCompleted(index)">
                            <div>
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="3" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                <span class="sr-only">completed</span>
                            </div>
                        </template>
                        <template x-if="!isCompleted(index)">
                            <span x-text="index+1"></span>
                        </template>
                    </span>
                    <span class="hidden w-max md:inline" x-text="step.title" x-bind:class="{
                        'text-rose-700 dark:text-rose-600': !isDisabled(index),
                        'font-bold': isCurrent(index),
                        'text-slate-700 dark:text-slate-300': isDisabled(index)
                    }"></span>
                </div>
            </li>
        </template>
    </ol>

    <form wire:submit="dev" class="mt-4" x-on:keyup.enter="nextStep">
        <!-- Form Motor -->
        <div x-cloak x-show="currentStep === 1"
            class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 md:gap-4 xl:grid-cols-4 2xl:gap-6 2xl:grid-cols-5">
            <h2 class="col-span-full">Spesifikasi Kendaraan</h2>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="keterangan" class="w-fit pl-0.5 text-sm sm:text-base">Keterangan</label>
                <input id="keterangan" type="text"
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="keterangan" placeholder="Masukkan keterangan" wire:model.blur="form.motor.keterangan" />
                @error('form.motor.keterangan') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="tahun_pembuatan" class="w-fit pl-0.5 text-sm sm:text-base">Tahun Pembuatan<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="tahun_pembuatan" type="number" min="2000" max="{{ date('Y') }}" placeholder="YYYY" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="tahun_pembuatan" wire:model.blur="form.motor.tahun_pembuatan" />
                @error('form.motor.tahun_pembuatan') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="merk" class="w-fit pl-0.5 text-sm sm:text-base">Merk<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input autocomplete="merk" id="merk" type="text" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="merk" placeholder="Masukkan merk" wire:model.blur="form.motor.merk" />
                @error('form.motor.merk') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="jenis" class="w-fit pl-0.5 text-sm sm:text-base">Jenis<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input autocomplete="jenis" id="jenis" type="text" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="jenis" placeholder="Masukkan jenis" wire:model.blur="form.motor.jenis" />
                @error('form.motor.jenis') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="kapasitas_mesin" class="w-fit pl-0.5 text-sm sm:text-base">Kapasitas Mesin<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <div class="flex">
                    <input id="kapasitas_mesin" type="number" min="0" max="1500" required
                        class="w-full px-2 py-2 text-sm border sm:text-base rounded-s-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                        name="kapasitas_mesin" placeholder="Masukkan kapasitas mesin"
                        wire:model.blur="form.motor.kapasitas_mesin" />
                    <p
                        class="inline-flex items-center p-2 text-sm tracking-widest border rounded-e-xl border-slate-300 bg-slate-200 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        CC
                    </p>
                </div>
                @error('form.motor.kapasitas_mesin') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="bahan_bakar" class="w-fit pl-0.5 text-sm sm:text-base">Bahan Bakar<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input autocomplete="bahan_bakar" id="bahan_bakar" type="text" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="bahan_bakar" placeholder="Masukkan bahan bakar" wire:model.blur="form.motor.bahan_bakar" />
                @error('form.motor.bahan_bakar') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="odometer" class="w-fit pl-0.5 text-sm sm:text-base">Odometer<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <div class="flex">
                    <input id="odometer" type="number" min="0" required
                        class="w-full px-2 py-2 text-sm border sm:text-base rounded-s-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                        name="odometer" placeholder="Masukkan odometer" wire:model.blur="form.motor.odometer" />
                    <p
                        class="inline-flex items-center p-2 text-sm tracking-widest border rounded-e-xl border-slate-300 bg-slate-200 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        KM
                    </p>
                </div>
                @error('form.motor.odometer') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="nomor_rangka" class="w-fit pl-0.5 text-sm sm:text-base">Nomor Rangka<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="nomor_rangka" type="text" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="nomor_rangka" placeholder="Masukkan nomor rangka" wire:model.blur="form.motor.nomor_rangka" />
                @error('form.motor.nomor_rangka') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="nomor_mesin" class="w-fit pl-0.5 text-sm sm:text-base">Nomor Mesin<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="nomor_mesin" type="text" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="nomor_mesin" placeholder="Masukkan nomor mesin" wire:model.blur="form.motor.nomor_mesin" />
                @error('form.motor.nomor_mesin') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <h2 class="col-span-full">Dokumen Kendaraan</h2>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="nomor_polisi" class="w-fit pl-0.5 text-sm sm:text-base">Nomor Polisi<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="nomor_polisi" type="text" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="nomor_polisi" placeholder="Masukkan nomor polisi" wire:model.blur="form.motor.nomor_polisi" />
                @error('form.motor.nomor_polisi') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="warna" autocomplete="warna" class="w-fit pl-0.5 text-sm sm:text-base">Warna<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="warna" type="text" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="warna" placeholder="Masukkan warna" wire:model.blur="form.motor.warna" />
                @error('form.motor.warna') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col justify-between gap-x-2">
                <label for="stnk" class="w-fit pl-0.5 text-sm sm:text-base">STNK<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <div class="flex gap-2">
                    <label for="stnk"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="stnk" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="stnk" value="1" wire:model.blur="form.motor.stnk">
                        <span class="text-sm sm:text-base">Ada</span>
                    </label>
                    <label for="x_stnk"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="x_stnk" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="stnk" value="0" wire:model.blur="form.motor.stnk">
                        <span class="text-sm sm:text-base">Tidak ada</span>
                    </label>
                </div>
                @error('form.motor.stnk') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="masa_berlaku_stnk" class="w-fit pl-0.5 text-sm sm:text-base">Masa Berlaku STNK<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="masa_berlaku_stnk" type="date" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="masa_berlaku_stnk" placeholder="Masukkan masa_berlaku_stnk"
                    wire:model.blur="form.motor.masa_berlaku_stnk" />
                @error('form.motor.masa_berlaku_stnk') <small class="pl-0.5 text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col justify-between gap-x-2">
                <label for="bpkb" class="w-fit pl-0.5 text-sm sm:text-base">BPKB<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <div class="flex gap-2">
                    <label for="bpkb"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="bpkb" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="bpkb" value="1" wire:model.blur="form.motor.bpkb">
                        <span class="text-sm sm:text-base">Ada</span>
                    </label>
                    <label for="x_bpkb"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="x_bpkb" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="bpkb" value="0" wire:model.blur="form.motor.bpkb">
                        <span class="text-sm sm:text-base">Tidak ada</span>
                    </label>
                </div>
                @error('form.motor.bpkb') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col justify-between gap-x-2">
                <label for="faktur" class="w-fit pl-0.5 text-sm sm:text-base">Faktur<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <div class="flex gap-2">
                    <label for="faktur"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="faktur" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="faktur" value="1" wire:model.blur="form.motor.faktur">
                        <span class="text-sm sm:text-base">Ada</span>
                    </label>
                    <label for="x_faktur"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="x_faktur" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="faktur" value="0" wire:model.blur="form.motor.faktur">
                        <span class="text-sm sm:text-base">Tidak ada</span>
                    </label>
                </div>
                @error('form.motor.faktur') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col justify-between gap-x-2">
                <label for="foto_kopi_ktp" class="w-fit pl-0.5 text-sm sm:text-base">Foto Kopi KTP<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <div class="flex gap-2">
                    <label for="foto_kopi_ktp"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="foto_kopi_ktp" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="foto_kopi_ktp" value="1" wire:model.blur="form.motor.foto_kopi_ktp">
                        <span class="text-sm sm:text-base">Ada</span>
                    </label>
                    <label for="x_foto_kopi_ktp"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="x_foto_kopi_ktp" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="foto_kopi_ktp" value="0" wire:model.blur="form.motor.foto_kopi_ktp">
                        <span class="text-sm sm:text-base">Tidak ada</span>
                    </label>
                </div>
                @error('form.motor.foto_kopi_ktp') <small class="pl-0.5 text-red-600">{{ $message }}</small>@enderror
            </div>
            <div class="flex flex-col justify-between gap-x-2">
                <label for="kwitansi_blanko" class="w-fit pl-0.5 text-sm sm:text-base">Kwitansi Blanko<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <div class="flex gap-2">
                    <label for="kwitansi_blanko"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="kwitansi_blanko" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="kwitansi_blanko" value="1" wire:model.blur="form.motor.kwitansi_blanko">
                        <span class="text-sm sm:text-base">Ada</span>
                    </label>
                    <label for="x_kwitansi_blanko"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="x_kwitansi_blanko" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="kwitansi_blanko" value="0" wire:model.blur="form.motor.kwitansi_blanko">
                        <span class="text-sm sm:text-base">Tidak ada</span>
                    </label>
                </div>
                @error('form.motor.kwitansi_blanko') <small class="pl-0.5 text-red-600">{{ $message }}</small>@enderror
            </div>
            <div class="flex flex-col justify-between gap-x-2">
                <label for="form_a" class="w-fit pl-0.5 text-sm sm:text-base">Form A<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <div class="flex gap-2">
                    <label for="form_a"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="form_a" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="form_a" value="1" wire:model.blur="form.motor.form_a">
                        <span class="text-sm sm:text-base">Ada</span>
                    </label>
                    <label for="x_form_a"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 pl-2 pr-4 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="x_form_a" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="form_a" value="0" wire:model.blur="form.motor.form_a">
                        <span class="text-sm sm:text-base">Tidak ada</span>
                    </label>
                </div>
                @error('form.motor.form_a') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
        </div>
        <div x-cloak x-show="currentStep === 2"
            class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 md:gap-4 xl:grid-cols-4 2xl:gap-6 2xl:grid-cols-5">
            <h2 class="col-span-full">Foto Motor</h2>
            @if (isset($form->lelang_model) && $form->foto_motor === $form->lelang_model->motor?->fotoMotor->toArray())
            @foreach ($form->foto_motor as $key => $image)
            <div class="relative w-full h-auto">
                <img src="{{ asset('storage/' .$image['src']) }}" alt="foto motor" class="w-full h-auto" />
            </div>
            @endforeach
            @elseif ($form->foto_motor)
            @foreach ($form->foto_motor as $key => $image)
            <div class="relative w-full h-auto">
                <img src="{{ asset($image->temporaryUrl()) }}" alt="foto motor" class="w-full h-auto" />
                <button type="button" wire:click="removeFotoMotor({{ $key }})"
                    class="absolute inset-x-0 bottom-0 bg-rose-500/90" aria-label="Remove image">
                    <span>Remove</span>
                </button>
            </div>
            @endforeach
            @endif
            <div class="relative flex flex-col w-full max-w-sm gap-1 text-slate-700 dark:text-slate-300 col-span-full">
                <label for="foto_motor" class="w-fit pl-0.5 text-sm">Upload File</label>
                <input id="foto_motor" type="file" wire:model.live="form.foto_motor" accept="image/*" multiple
                    class="w-full max-w-md text-sm border overflow-clip rounded-xl border-slate-300 bg-slate-100/50 file:mr-4 file:cursor-pointer file:border-none file:bg-slate-100 file:px-4 file:py-2 file:font-medium file:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:file:bg-slate-800 dark:file:text-white dark:focus-visible:outline-blue-600" />
                <small class="pl-0.5">PNG, JPG, WebP - Max 2MB</small>
            </div>
            @error('form.foto_motor') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            @error('form.foto_motor.*') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
        </div>
        <div x-cloak x-show="currentStep === 3" class="flex flex-col flex-wrap max-w-lg gap-2 md:gap-4 2xl:gap-6">
            <h2 class="w-full">Nasabah</h2>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="nasabah.nama" class="w-fit pl-0.5 text-sm sm:text-base">Nama<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input autocomplete="nama" id="nasabah.nama" type="text" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="nasabah.nama" placeholder="Masukkan nama" wire:model.blur="form.nasabah.nama" />
                @error('form.nasabah.nama') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="nasabah.alamat" class="w-fit pl-0.5 text-sm sm:text-base">Alamat<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="nasabah.alamat" type="text" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="nasabah.alamat" placeholder="Masukkan alamat" wire:model.blur="form.nasabah.alamat" />
                @error('form.nasabah.alamat') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="nasabah.no_hp" class="w-fit pl-0.5 text-sm sm:text-base">No HP<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="nasabah.no_hp" type="text" required inputmode="numeric" minlength="9" maxlength="13"
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="nasabah.no_hp" placeholder="Masukkan no_hp" wire:model.blur="form.nasabah.no_hp" />
                @error('form.nasabah.no_hp') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="nasabah.utang" class="w-fit pl-0.5 text-sm sm:text-base">Utang<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="nasabah.utang" type="number" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="nasabah.utang" placeholder="Masukkan utang" wire:model.blur="form.nasabah.utang" />
                @error('form.nasabah.utang') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
        </div>
        <div x-cloak x-show="currentStep === 4" class="flex flex-col flex-wrap max-w-lg gap-2 md:gap-4 2xl:gap-6">
            <h2 class="w-full">Lelang</h2>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="lelang.keterangan" class="w-fit pl-0.5 text-sm sm:text-base">Keterangan</label>
                <input id="lelang.keterangan" type="text" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="lelang.keterangan" placeholder="Masukkan keterangan"
                    wire:model.blur="form.lelang.keterangan" />
                @error('form.lelang.keterangan') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="lelang.status_lelang" class="w-fit pl-0.5 text-sm sm:text-base">Status Lelang<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <select id="lelang.status_lelang" name="lelang.status_lelang"
                    wire:model.live="form.lelang.status_lelang"
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600">
                    <option value="akan datang">Akan Datang</option>
                    <option value="berlangsung">Berlangsung</option>
                    <option value="selesai">Selesai</option>
                </select>
                @error('form.lelang.status_lelang') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="lelang.waktu_mulai_lelang" class="w-fit pl-0.5 text-sm sm:text-base">Waktu Mulai Lelang<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="lelang.waktu_mulai_lelang" type="datetime-local" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="lelang.waktu_mulai_lelang" placeholder="Masukkan waktu_mulai_lelang"
                    wire:model.blur="form.lelang.waktu_mulai_lelang" />
                @error('form.lelang.waktu_mulai_lelang') <small class="pl-0.5 text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="lelang.waktu_selesai_lelang" class="w-fit pl-0.5 text-sm sm:text-base">Waktu Selesai
                    Lelang<sup class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="lelang.waktu_selesai_lelang" type="datetime-local" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="lelang.waktu_selesai_lelang" placeholder="Masukkan waktu_selesai_lelang"
                    wire:model.blur="form.lelang.waktu_selesai_lelang" />
                @error('form.lelang.waktu_selesai_lelang') <small class="pl-0.5 text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="lelang.harga_awal" class="w-fit pl-0.5 text-sm sm:text-base">Harga Awal<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="lelang.harga_awal" type="number" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="lelang.harga_awal" placeholder="Masukkan harga_awal"
                    wire:model.blur="form.lelang.harga_awal" />
                @error('form.lelang.harga_awal') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
            <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
                <label for="lelang.uang_jaminan" class="w-fit pl-0.5 text-sm sm:text-base">Uang Jaminan<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <input id="lelang.uang_jaminan" type="number" required
                    class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="lelang.uang_jaminan" placeholder="Masukkan uang_jaminan"
                    wire:model.blur="form.lelang.uang_jaminan" />
                @error('form.lelang.uang_jaminan') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
            </div>
        </div>
    </form>

    <div class="flex justify-between gap-2">
        <button type="button" @click="previousStep" x-show="currentStep > 1"
            class="[&>svg]:size-6 inline-flex gap-x-2 items-center pl-2 pr-4 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-300 dark:focus-visible:outline-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                </path>
            </svg>
            <span>Back</span>
        </button>
        <div class="flex-1"></div>
        <button type="button" @click="nextStep"
            class="[&>svg]:size-6 inline-flex gap-x-2 items-center pr-2 pl-4 py-2 text-md font-medium tracking-wide text-center transition bg-transparent cursor-pointer active:outline outline-slate-300 dark:outline-slate-700 whitespace-nowrap rounded-xl text-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:text-slate-300 dark:focus-visible:outline-white">
            <span x-text="currentStep === steps.length ? 'Submit' : 'Next'"></span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                x-show="currentStep !== steps.length">
                <path
                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                </path>
            </svg>
        </button>
    </div>
</div>