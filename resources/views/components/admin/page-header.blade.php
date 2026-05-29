@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6 md:hidden']) }}>
  <div>
    @if($subtitle)
      <p class="text-sm text-neutral-500">{{ $subtitle }}</p>
    @endif
    <h2 class="text-2xl font-bold text-neutral-900">{{ $title }}</h2>
  </div>
  @isset($actions)
    <div class="flex flex-wrap items-center gap-2 shrink-0">
      {{ $actions }}
    </div>
  @endisset
</div>
