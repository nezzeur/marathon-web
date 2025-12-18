@extends('layout.app')

@section('contenu')
    <style>
        /* Style spécifique pour la page d'édition de profil - synthwave/rétro */
        .edit-profile-container {
            background: linear-gradient(135deg, rgba(13, 2, 33, 0.8) 0%, rgba(26, 5, 51, 0.6) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(43, 231, 198, 0.2);
            box-shadow: 0 0 20px rgba(43, 231, 198, 0.1);
        }
        
        /* Effet de scanline pour le contenu */
        .scanline-content {
            background-image: repeating-linear-gradient(
                to bottom,
                transparent 0px,
                rgba(43, 231, 198, 0.05) 1px,
                transparent 2px
            );
        }
    </style>

    <div class="max-w-2xl mx-auto p-5 edit-profile-container">
        <h1 class="text-4xl font-bold mb-8 text-foreground chrome-text animate-glow-pulse">MODIFIER_PROFILE</h1>

        @if($errors->any())
            <div class="bg-red-500/10 border-l-4 border-red-500 p-4 mb-8 rounded">
                <strong class="text-red-400">❌ ERREURS :</strong>
                <ul class="mt-3 space-y-1 text-red-400">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" class="bg-card rounded-lg shadow-lg shadow-primary/20 p-8 space-y-6 border border-border scanline-content">
            @csrf
            @method('PUT')

            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-bold text-primary mb-2">NOM :</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-2 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-bold text-primary mb-2">EMAIL :</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground">
            </div>

            <!-- Avatar -->
            <div>
                <label for="avatar" class="block text-sm font-bold text-primary mb-2">AVATAR :</label>
                @if($user->avatar)
                    <div class="mb-4 p-4 bg-card/50 rounded-lg border border-border">
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar actuel" class="w-40 h-40 rounded-lg object-cover border-4 border-primary">
                        <p class="text-muted-foreground text-sm mt-3">CURRENT_AVATAR</p>
                    </div>
                @endif
                <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp"
                       class="w-full px-4 py-2 border border-border bg-card/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground file:bg-primary file:text-primary-foreground file:border-0 file:rounded-lg file:px-4 file:py-2 file:mr-4 file:hover:bg-primary/80 file:hover:cursor-pointer">
                <small class="text-muted-foreground block mt-2">FORMAT_ACCEPTER : JPEG, PNG, GIF, WebP (MAX 2MB)</small>
            </div>

            <!-- Boutons -->
            <div class="flex gap-4 pt-6 border-t border-border">
                <x-nav-button type="submit" icon="💾" class="flex-1">
                    SAUVEGARDER
                </x-nav-button>
                <x-nav-button type="link" href="{{ route('user.me') }}" color="destructive" icon="❌" class="flex-1">
                    ANNULER
                </x-nav-button>
            </div>
        </form>
    </div>
@endsection

