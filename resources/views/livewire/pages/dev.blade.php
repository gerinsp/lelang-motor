<?php

use function Livewire\Volt\{layout, mount, state};
use App\Models\User;

layout('layouts.guest');

mount(function () {
    // $this->count = User::count();
});

state([
    'count' => 
    [    
        'banyak' => 1,
        'satuan' => 0,
        'puluhan' => 10,
        'ratusan' => 100,
        'ribuan' => 1000,
    ]
]);

$increment = function () {
    $this->count['satuan'] += $this->count['banyak'];
};

$runJob = function () {
    dispatch(function () {
        logger('Job started');
    });
};

?>

<div class="p-4 text-center bg-red-100">
    <h1 wire:click='runJob'>Welcome to Dev</h1>
    <h1>{{ $count['satuan'] }}</h1>
    <h1>{{ $count['puluhan'] }}</h1>
    <h1>{{ $count['ratusan'] }}</h1>
    <h1>{{ $count['ribuan'] }}</h1>
    <input type="number" wire:model.live="count.banyak" />
    <button wire:click="increment" wire:loading.remove>Increment</button>
</div>