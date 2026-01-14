<!-- resources/views/components/nav-link-sidebar.blade.php -->
@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'flex items-center p-2 text-base font-normal text-white bg-emerald-500 rounded-lg'
            : 'flex items-center p-2 text-base font-normal text-gray-300 rounded-lg hover:bg-gray-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <i class="{{ $icon }} w-6 h-6 text-gray-400 transition duration-75 group-hover:text-white"></i>
    <span class="ml-3">{{ $slot }}</span>
</a>
