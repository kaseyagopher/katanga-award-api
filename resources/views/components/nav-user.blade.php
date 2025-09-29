<div class="flex justify-between h-16 items-center">
    <div class="flex space-x-4">
      <a href="{{route('user.index')}}" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Accueil</a>
      <a href="#" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Catégories</a>
      <a href="#" class="text-gray-700 hover:text-[#A28224] font-semibold px-3 py-2 rounded-md">Résultats</a>
    </div>
    <div>
      <a href="{{route('user.vote')}}" class="bg-[#A28224] text-white px-4 py-2 rounded-md hover:bg-[#A28224]/90 focus:outline-none focus:ring-2 focus:ring-[#A28224]/50">
        Voter
      </a>
      @if(Auth::guard('web')->check())
        <strong class="px-4">{{ Auth::guard('web')->user()->numero ?? Auth::guard('web')->user()->email }}</strong>
      @else
        <p class="text-orange-500 font-semibold">UNKNOW</p>
      @endif
    </div>
</div>