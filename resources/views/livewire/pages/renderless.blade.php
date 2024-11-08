<?php

use function Livewire\Volt\{action, mount, title, state, updated, usesPagination, with};
use App\Models\FotoMotor;

usesPagination();
title(fn () => 'Foto: ' . $this->foto_motor->count());

mount(function () {
    $nama;
    dd($nama);
});

state(['foto_motor' => FotoMotor::all()]);

state(['search', 'perPage'])->url();

// With digunakan untuk view tiap kali render, jadi bukan state tapi bisa jadi state
// with(fn () => ['foto_motor' => FotoMotor::paginate(5)]);

updated(['search' => fn () => $this->perPage = 0]);

$deleteFoto = action(fn (FotoMotor $fotoMotor) => $fotoMotor->delete())->renderless();

$devDispatch = fn() => $this->dispatch('notify', variant: 'success', title: 'Success', message: 'Dispatched lorem ipsum sit dolor amet');


?>

<div>
    <h1>Renderless</h1>
    <div>
        <input type="text" wire:model.live.debounce.250ms="search" />
        <button type="button" wire:click="devDispatch">
            Search
        </button>
    </div>
    <div>
        <button wire:click="perPage = 10">10</button>
        <button wire:click="perPage = 25">25</button>
        <button wire:click="perPage = 50">50</button>
        <button wire:click="perPage = 100">100</button>
        <button wire:click="perPage = 200">200</button>
    </div>
    <ul x-data="{
        fotoMotor: {{ $foto_motor }},
        deleteFoto(fotoMotor) {
            this.fotoMotor = this.fotoMotor.filter(foto => foto.id !== fotoMotor.id);
            $wire.deleteFoto(fotoMotor);
        }
    }">
        <template x-for="(foto, index) in fotoMotor" :key="index">
            <li class="flex justify-between">
                <span x-text="foto.alt"></span>
                <button @click="deleteFoto(foto)">
                    X
                </button>
            </li>
        </template>
    </ul>
</div>