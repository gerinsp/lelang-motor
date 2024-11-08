<?php

use function Livewire\Volt\{state};

?>

<div class="p-4 text-center">
    <h1>Route Name: {{ request()->route()->getName() }}</h1>
</div>