@extends('layouts.user', ['showLoader' => true])

@section('title', 'Contact — Katanga Awards')
@section('main-class', 'max-w-xl mx-auto px-4 sm:px-6 py-8')

@section('content')
  <x-ka.section-heading subtitle="Écrivez-nous" icon="mail">
    Contact
  </x-ka.section-heading>

  <p class="text-neutral-400 text-sm mb-8 -mt-4">Partenariat, presse ou question — nous vous répondrons rapidement.</p>

  <form action="{{ route('user.mail') }}" method="POST" class="rounded-2xl border border-ka-gold/30 bg-ka-card p-6 sm:p-8 space-y-5">
    @csrf
    @foreach(['nom' => 'Nom complet', 'email' => 'Email', 'sujet' => 'Sujet'] as $field => $label)
      <div>
        <label class="mb-1.5 block text-sm font-medium text-ka-yellow/90">{{ $label }}</label>
        <input type="{{ $field === 'email' ? 'email' : 'text' }}" name="{{ $field }}" required
               class="w-full rounded-xl border border-neutral-700 bg-black px-4 py-2.5 text-white focus:border-ka-gold focus:ring-2 focus:ring-ka-gold/30 outline-none">
      </div>
    @endforeach
    <div>
      <label class="mb-1.5 block text-sm font-medium text-ka-yellow/90">Message</label>
      <textarea name="message" rows="5" required
                class="w-full rounded-xl border border-neutral-700 bg-black px-4 py-2.5 text-white focus:border-ka-gold focus:ring-2 focus:ring-ka-gold/30 outline-none resize-y"></textarea>
    </div>
    <x-ka.button type="submit" variant="primary" size="lg" class="w-full">
      <span class="material-icons">send</span>
      Envoyer
    </x-ka.button>
  </form>
@endsection
