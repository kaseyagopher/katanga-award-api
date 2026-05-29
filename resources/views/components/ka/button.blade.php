@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
])

@php
  $base = 'inline-flex items-center justify-center gap-2 font-semibold rounded-xl transition focus:outline-none focus:ring-2 focus:ring-ka-gold/50 focus:ring-offset-2 focus:ring-offset-black disabled:opacity-50 disabled:pointer-events-none';
  $variants = [
    'primary' => 'bg-ka-gold text-white shadow-md shadow-ka-gold/30 hover:bg-ka-amber hover:text-black',
    'secondary' => 'bg-ka-yellow text-black shadow-md shadow-ka-yellow/20 hover:bg-ka-amber',
    'outline' => 'border-2 border-ka-gold text-ka-yellow bg-transparent hover:bg-ka-gold/15',
    'ghost' => 'text-ka-yellow hover:bg-ka-gold/10',
  ];
  $sizes = [
    'sm' => 'px-4 py-2 text-sm',
    'md' => 'px-6 py-3 text-sm',
    'lg' => 'px-8 py-4 text-base',
  ];
  $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
  </a>
@else
  <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
  </button>
@endif
