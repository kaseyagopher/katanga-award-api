<div class="bg-black shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo / Liens -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('user.index') }}" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Accueil</a>
                <a href="#" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Catégories</a>
                <a href="#" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Résultats</a>
            </div>

            <!-- Boutons utilisateur -->
            <div class="flex items-center space-x-2">
                @if(Auth::guard('web')->check())
                    @php
                        $editionActive = \App\Models\Edition::where('statut', true)->first();
                        $aVote = false;

                        if($editionActive) {
                            $aVote = \App\Models\Vote::where('user_id', Auth::guard('web')->id())
                                                      ->where('edition_id', $editionActive->id)
                                                      ->exists();
                        }
                    @endphp

                    @if($editionActive && !$aVote)
                        <a href="{{ route('user.vote') }}" 
                           class="bg-[#4CAF50] text-white px-4 py-2 rounded-md hover:bg-[#45a049] focus:outline-none focus:ring-2 focus:ring-[#4CAF50]/50 whitespace-nowrap">
                            Voter
                        </a>
                    @elseif($editionActive)
                        <span class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md cursor-not-allowed whitespace-nowrap">
                            Vous avez déjà voté
                        </span>
                    @else
                        <span class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md cursor-not-allowed whitespace-nowrap">
                            Pas d'édition active
                        </span>
                    @endif

                    <strong class="px-4 truncate max-w-[120px] text-right">
                        {{ Auth::guard('web')->user()->numero ?? Auth::guard('web')->user()->email }}
                    </strong>
                @else
                    <p class="text-orange-500 font-semibold">UNKNOW</p>
                @endif
            </div>

            <!-- Hamburger mobile -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                    <span class="material-icons">menu</span>
                </button>
            </div>
        </div>

        <!-- Menu mobile -->
        <div id="mobile-menu" class="hidden md:hidden mt-2 space-y-2">
            <a href="{{ route('user.index') }}" class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Accueil</a>
            <a href="#" class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Catégories</a>
            <a href="#" class="block text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Résultats</a>
        </div>
    </div>
</div>

<script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>
