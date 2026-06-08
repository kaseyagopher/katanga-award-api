@if($consultationEdition ?? null)
  <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 rounded-xl border border-amber-300 bg-amber-50 px-4 py-3 text-sm text-amber-950">
    <div class="flex items-start gap-2">
      <span class="material-icons text-amber-600 shrink-0">visibility</span>
      <div>
        <p class="font-semibold">Mode consultation</p>
        <p class="text-amber-800/90">
          Vous consultez la session « {{ $consultationEdition->titre }} » (clôturée).
          Les données affichées dans l'admin correspondent à cette édition.
        </p>
      </div>
    </div>
    <form action="{{ route('editions.consultation.leave') }}" method="POST" class="shrink-0">
      @csrf
      <button type="submit"
              class="inline-flex items-center gap-1 rounded-lg border border-amber-400 bg-white px-3 py-2 text-xs font-semibold text-amber-900 hover:bg-amber-100 transition">
        <span class="material-icons text-[16px]">close</span>
        Quitter la consultation
      </button>
    </form>
  </div>
@endif
