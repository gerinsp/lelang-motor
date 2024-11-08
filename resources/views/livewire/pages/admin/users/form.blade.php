<?php
use App\Models\User;
use App\Livewire\Forms\UserForm;
use function Livewire\Volt\{form, mount, state, title, usesFileUploads};

title(fn() => ucfirst($this->page) . ' ' . ($this->form->name ? $this->form->name : 'User'));
usesFileUploads();

form(UserForm::class);

mount(function(?User $user) {
    if(request()->routeIs('admin.users.create')){
        $this->page = 'create';
    } elseif (request()->routeIs('admin.users.edit')) {
        $this->page = 'edit';
    } elseif (request()->routeIs('profile')) {
        $this->page = 'Profile';
        $user = auth()->user();
    }
    $this->form->setData($user);
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
    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil menambahkan user ' . $this->form->name);

    // return $this->redirectRoute('admin.users.index', navigate: true);
};

$update = function () {
    $this->form->update();
    $this->dispatch('notify', variant: 'success', title: 'Sukses', message: 'Berhasil memperbarui user ' . $this->form->name);

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
        <h1 class="capitalize">{{ $page }} User</h1>
        <a href="{{ route('admin.users.index') }}" wire:navigate
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
            <label for="name" class="w-fit pl-0.5 text-sm sm:text-base ">Name<sup
                    class="text-rose-700 dark:text-rose-600">*</sup></label>
            <input id="name" type="text"
                class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                name="name" placeholder="Enter your name" autocomplete="name" wire:model.blur="form.name" />
            @error('form.name') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
        </div>
        <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
            <label for="email" class="w-fit pl-0.5 text-sm sm:text-base ">Email<sup
                    class="text-rose-700 dark:text-rose-600">*</sup></label>
            <input id="email" type="email"
                class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                name="email" placeholder="Enter your email" autocomplete="email" wire:model.blur="form.email" />
            @error('form.email') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
        </div>
        <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
            <label for="passwordInput" class="w-fit pl-0.5 text-sm">Password<sup
                    class="text-rose-700 dark:text-rose-600">*</sup></label>
            <div x-data="{ showPassword: false }" class="relative">
                <input :type="showPassword ? 'text' : 'password'" id="passwordInput"
                    class="w-full px-2 py-2 text-sm border rounded-xl border-slate-300 bg-slate-100 focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
                    name="password" autocomplete="current-password" placeholder="Enter your password"
                    wire:model.blur="form.password" />
                <button type="button" @click="showPassword = !showPassword"
                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-700 dark:text-slate-300"
                    aria-label="Show password">
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            @error('form.password') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
        </div>
        <div class="relative flex flex-col w-full gap-1">
            <label class="w-fit pl-0.5 text-sm text-slate-700 dark:text-slate-300" for="avatar">Upload File</label>
            <input id="avatar" type="file" wire:model.blur="form.avatar" accept="image/*"
                class="w-full text-sm border overflow-clip rounded-xl border-slate-300 focus:ring-0 bg-slate-100/50 text-slate-700 file:mr-4 file:cursor-pointer file:border-none file:bg-slate-100 file:px-4 file:py-2 file:font-medium file:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-300 dark:file:bg-slate-800 dark:file:text-white dark:focus-visible:outline-rose-600" />
            @error('form.avatar') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
        </div>
        <div class="flex items-center justify-end gap-x-2">
            @if (auth()->user()->is_admin)
            <div>
                <label for="user" class="w-fit pl-0.5 text-sm sm:text-base">Status<sup
                        class="text-rose-700 dark:text-rose-600">*</sup></label>
                <div class="flex gap-2">
                    <label for="admin"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 px-2 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="admin" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="radioDefault" value="1" wire:model.blur="form.is_admin">
                        <span class="text-sm sm:text-base">Admin</span>
                    </label>
                    <label for="user"
                        class="flex w-fit cursor-pointer items-center justify-start gap-2 rounded-xl border border-slate-300 bg-slate-100 px-2 py-2 font-medium text-slate-700 has-[:disabled]:opacity-75 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <input id="user" type="radio"
                            class="before:content[''] relative h-4 w-4 appearance-none rounded-full border focus:ring-0 border-slate-300 bg-white before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-slate-100 checked:border-rose-700 checked:bg-rose-700 checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-slate-800 checked:focus:outline-rose-700 disabled:cursor-not-allowed dark:border-slate-700 dark:bg-slate-900 dark:before:bg-slate-100 dark:checked:border-rose-600 dark:checked:bg-rose-600 dark:focus:outline-slate-300 dark:checked:focus:outline-rose-600"
                            name="radioDefault" value="0" wire:model.blur="form.is_admin">
                        <span class="text-sm sm:text-base">User</span>
                    </label>
                    @error('form.is_admin') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
                </div>
            </div>
            @endif
            <div class="flex-1"></div>
            @if (isset($form->user->avatar) && $form->user->avatar === $form->avatar)
            <img src="{{ asset('storage/' .$form->user->avatar) }}" alt="avatar" class="w-16 h-16 rounded-full" />
            @elseif ($form->avatar)
            <img src="{{ asset($form->avatar->temporaryUrl()) }}" alt="avatar" class="w-16 h-16 rounded-full" />
            @else
            <idv class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 outline outline-1 outline-slate-300 dark:outline-slate-700"
                wire:loading.class="animate-pulse" />
            @endif
        </div>
        <div class="flex flex-col w-full gap-1 text-slate-700 dark:text-slate-300">
            <label for="saldo" class="w-fit pl-0.5 text-sm sm:text-base ">Saldo</label>
            <input id="saldo" type="number" wire:model.blur="form.saldo" {{ auth()->user()->is_admin ? '' : 'disabled'
            }}
            class="w-full px-2 py-2 text-sm border sm:text-base rounded-xl focus:ring-0 border-slate-300 bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-700 disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700 dark:bg-slate-800/50 dark:focus-visible:outline-rose-600"
            name="saldo" placeholder="Masukkan saldo" />
            @error('form.saldo') <small class="pl-0.5 text-red-600">{{ $message }}</small> @enderror
        </div>
        {{-- Button submit --}}
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