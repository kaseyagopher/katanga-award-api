@if(session('success'))
  <div class="mb-6 flex items-start gap-3 rounded-xl border border-green-800/60 bg-green-950/40 px-4 py-3 text-green-300">
    <span class="material-icons shrink-0 text-green-400">check_circle</span>
    <p class="text-sm font-medium">{{ session('success') }}</p>
  </div>
@endif

@if(session('error'))
  <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-800/60 bg-red-950/40 px-4 py-3 text-red-300">
    <span class="material-icons shrink-0 text-red-400">error</span>
    <p class="text-sm font-medium">{{ session('error') }}</p>
  </div>
@endif

@if(isset($errors) && $errors->any())
  <div class="mb-6 rounded-xl border border-red-800/60 bg-red-950/40 px-4 py-3">
    <ul class="list-disc list-inside text-sm text-red-300 space-y-1">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
