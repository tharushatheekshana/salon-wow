@props([
    'sidebar' => false,
])

@if($sidebar)
    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-2 py-1 group" {{ $attributes }}>
        <img src="/images/salon-wow-logo.jpg" alt="Salon WOW Logo" class="w-8 h-8 rounded-lg object-cover border border-amber-500/30 shadow-xs">
        <span class="font-bold text-base tracking-tight text-neutral-900 dark:text-white">SALON <span class="text-rose-600">WOW</span></span>
    </a>
@else
    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group" {{ $attributes }}>
        <img src="/images/salon-wow-logo.jpg" alt="Salon WOW Logo" class="w-8 h-8 rounded-lg object-cover border border-amber-500/30 shadow-xs">
        <span class="font-bold text-base tracking-tight text-neutral-900 dark:text-white">SALON <span class="text-rose-600">WOW</span></span>
    </a>
@endif
