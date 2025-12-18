@props([
    'recommendedUsers' => collect(),
    'title' => 'Utilisateurs recommandés',
    'showScore' => false
])

@if($recommendedUsers->count() > 0)
<div class="bg-black/70 backdrop-blur-md rounded-2xl border border-white/10 p-6">
    <h3 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#bed2ff] to-[#ff8dc7] mb-6">
        {{ $title }}
    </h3>
    
    <div class="space-y-4">
        @foreach($recommendedUsers as $user)
        <div class="flex items-center justify-between p-4 rounded-lg bg-black/50 hover:bg-black/60 transition-colors">
            <div class="flex items-center gap-4">
                <!-- Avatar -->
                <div class="relative">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/no-profile-picture.png') }}"
                         alt="{{ $user->name }}" 
                         class="w-12 h-12 rounded-full object-cover border-2 border-gradient-from-[#2858bb] border-gradient-to-[#c2006d] p-0.5">
                </div>
                
                <!-- Infos utilisateur -->
                <div>
                    <h4 class="font-semibold text-white">{{ $user->name }}</h4>
                    <p class="text-sm text-gray-400">
                        {{ $user->articles_count ?? $user->articles->count() }} articles • 
                        {{ $user->suiveurs_count ?? $user->suiveurs->count() }} abonnés
                    </p>
                </div>
            </div>
            
            <!-- Bouton suivre et score -->
            <div class="flex items-center gap-3">
                @if($showScore)
                <div class="bg-gradient-to-r from-[#2858bb] to-[#c2006d] text-white text-xs px-2 py-1 rounded-full font-bold">
                    {{ round($user->similarity_score ?? 0) }}%
                </div>
                @endif
                
                <form action="{{ route('user.toggleFollow', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="bg-gradient-to-r from-[#2858bb] to-[#c2006d] text-white px-4 py-2 rounded-lg text-sm font-medium hover:opacity-90 transition-opacity">
                        @if(auth()->check() && auth()->user()->suivis->contains($user))
                            Ne plus suivre
                        @else
                            + Suivre
                        @endif
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif