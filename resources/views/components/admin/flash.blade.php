@if(session('success'))
  <div class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800 shadow-sm" role="alert">
    <span class="material-icons text-green-600 shrink-0">check_circle</span>
    <p class="text-sm font-medium">{{ session('success') }}</p>
  </div>
@endif

@if(session('error'))
  <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm" role="alert">
    <span class="material-icons text-red-600 shrink-0">error</span>
    <p class="text-sm font-medium">{{ session('error') }}</p>
  </div>
@endif

@if($errors->any())
  <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 shadow-sm" role="alert">
    <div class="flex items-center gap-2 text-red-800 font-semibold text-sm mb-2">
      <span class="material-icons text-base">warning</span>
      Veuillez corriger les erreurs suivantes
    </div>
    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
