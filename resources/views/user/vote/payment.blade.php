@extends('layouts.user')

@section('title', 'Paiement — Katanga Awards')
@section('main-class', 'max-w-lg mx-auto px-4 sm:px-6 py-8')

@section('content')
  <div class="text-center mb-8">
    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-ka-gold/20 ring-2 ring-ka-yellow">
      <span class="material-icons text-4xl text-ka-yellow">payments</span>
    </div>
    <p class="text-xs font-semibold uppercase tracking-widest text-ka-yellow">Étape finale</p>
    <h1 class="text-2xl font-bold text-white mt-1">Paiement</h1>
    <p class="text-sm text-neutral-500 mt-1">{{ $pending['edition_titre'] }} · <span class="text-ka-amber">simulation</span></p>
  </div>

  <div class="rounded-2xl border border-ka-gold/30 bg-ka-card p-5 mb-4 space-y-3">
    <h2 class="text-xs font-bold uppercase tracking-wide text-ka-gold">Récapitulatif</h2>
    @foreach($pending['selections'] as $item)
      <div class="flex justify-between gap-2 text-sm py-2 border-b border-neutral-800 last:border-0">
        <span class="text-neutral-500">{{ $item['categorie_nom'] }}</span>
        <span class="text-white font-medium text-right">{{ $item['candidat_nom'] }}</span>
      </div>
    @endforeach
  </div>

  <div class="rounded-2xl border-2 border-ka-yellow bg-gradient-to-br from-ka-gold/20 to-transparent p-5 mb-6 flex justify-between items-center">
    <span class="text-neutral-300">Total</span>
    <span class="text-3xl font-bold ka-gradient-text">
      {{ number_format($pending['total'], 0, ',', ' ') }} {{ $pending['currency'] }}
    </span>
  </div>

  <form action="{{ route('vote.payment.process') }}" method="POST" id="payment-form" class="space-y-4">
    @csrf
    <fieldset class="space-y-2">
      <legend class="text-sm font-semibold text-ka-yellow mb-2">Mode de paiement</legend>
      @foreach([
        'orange_money' => ['Orange Money', 'phone_android'],
        'airtel_money' => ['Airtel Money', 'account_balance_wallet'],
        'vodacom_mpesa' => ['M-Pesa', 'smartphone'],
        'carte' => ['Carte', 'credit_card'],
      ] as $value => [$label, $icon])
        <label class="flex items-center gap-3 rounded-xl border border-neutral-700 bg-black/50 p-4 cursor-pointer has-[:checked]:border-ka-yellow has-[:checked]:bg-ka-gold/10">
          <input type="radio" name="payment_method" value="{{ $value }}" class="accent-ka-gold" {{ $loop->first ? 'checked' : '' }} required>
          <span class="material-icons text-ka-yellow">{{ $icon }}</span>
          <span class="font-medium">{{ $label }}</span>
        </label>
      @endforeach
    </fieldset>

    <p class="text-xs text-neutral-500 flex gap-2 rounded-lg bg-black/40 p-3 border border-neutral-800">
      <span class="material-icons text-ka-gold text-sm shrink-0">info</span>
      Simulation : aucun débit réel. Votre vote sera enregistré immédiatement.
    </p>

    <x-ka.button type="submit" variant="primary" size="lg" class="w-full" id="pay-btn">
      <span class="material-icons">lock</span>
      Payer {{ number_format($pending['total'], 0, ',', ' ') }} {{ $pending['currency'] }}
    </x-ka.button>

    <x-ka.button :href="route('user.vote')" variant="ghost" size="sm" class="w-full">
      Modifier ma sélection
    </x-ka.button>
  </form>
@endsection

@push('scripts')
<script>
  document.getElementById('payment-form')?.addEventListener('submit', function () {
    const btn = document.getElementById('pay-btn');
    if (btn) { btn.disabled = true; btn.innerHTML = '<span class="material-icons animate-spin">hourglass_empty</span> Traitement…'; }
  });
</script>
@endpush
