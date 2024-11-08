@props([
'type' => 'button',
'variant' => 'primary',
'size' => 'md',
'title' => 'just button',
])

@php

$baseClasses = '[&>svg]:size-5 inline-flex gap-2 items-center justify-center font-semibold rounded-md transition
ease-in-out duration-150
focus:outline-none focus:ring';

// Variasi gaya berdasarkan jenis button
$variantClasses = match($variant) {
// tambahkan versi dark
'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-400
dark:focus:ring-blue-400',
'secondary' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500 dark:bg-gray-500 dark:hover:bg-gray-400
dark:focus:ring-gray-400',
'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 dark:bg-red-500 dark:hover:bg-red-400
dark:focus:ring-red-400',
'default' => 'bg-gray-200 text-gray-800 hover:bg-gray-300 focus:ring-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600
dark:focus:ring-gray-500',
'ghost' => 'bg-transparent text-slate-700 hover:bg-slate-100 focus:ring-slate-300 dark:bg-transparent
dark:text-slate-400 dark:hover:bg-slate-800 dark:focus:ring-slate-700',
};

// Ukuran button berdasarkan size
$sizeClasses = match($size) {
'sm' => 'px-2 py-1 text-sm',
'md' => 'px-4 py-2 text-base',
'lg' => 'px-6 py-3 text-lg',
'default' => 'px-4 py-2 text-base',
};
@endphp

<button type="{{ $type }}" title="{{ $title }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses .
    ' ' . $sizeClasses]) }}>
    {{ $slot }}
</button>