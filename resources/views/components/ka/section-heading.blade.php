@props(['subtitle' => null, 'icon' => null])

<div {{ $attributes->merge(['class' => 'mb-8']) }}>
  @if($subtitle)
    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-ka-gold mb-2">{{ $subtitle }}</p>
  @endif
  <h2 class="flex items-center gap-3 text-2xl sm:text-3xl font-bold text-white">
    @if($icon)
      <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-ka-gold/20 text-ka-yellow">
        <span class="material-icons">{{ $icon }}</span>
      </span>
    @endif
    <span>{{ $slot }}</span>
  </h2>
</div>
