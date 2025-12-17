@extends("layout.app")

@section('contenu')
    <div class="min-h-screen flex items-center justify-center px-4 py-12" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%)">
        <div class="w-full max-w-md">
            <!-- Carte de login -->
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
                <!-- En-tête -->
                <div class="p-8 text-center" style="background: linear-gradient(135deg, #2B5BBB 0%, #C2006D 100%)">
                    <h1 class="text-4xl font-bold text-white mb-2">🔐 Connexion</h1>
                    <p class="text-opacity-90 text-white">Bienvenue sur Marathon</p>
                </div>

                <!-- Formulaire -->
                <form action="{{ route('login') }}" method="post" class="p-8 space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">📧 Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            required
                            placeholder="votre@email.com"
                            class="w-full px-4 py-3 border-2 rounded-lg focus:outline-none focus:ring-0 transition-colors"
                            style="border-color: #2BE7C6; focus:border-color #2B5BBB"
                            value="{{ old('email') }}"
                        />
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">🔑 Mot de passe</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-3 border-2 rounded-lg focus:outline-none focus:ring-0 transition-colors"
                            style="border-color: #2BE7C6"
                        />
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Se souvenir -->
                    <div class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            class="w-5 h-5 rounded"
                            style="accent-color: #2B5BBB"
                        />
                        <label for="remember" class="text-sm text-gray-700 font-medium">Se souvenir de moi</label>
                    </div>

                    <!-- Bouton de connexion -->
                    <button
                        type="submit"
                        class="w-full font-bold py-3 rounded-lg text-white text-lg transition-opacity hover:opacity-90"
                        style="background: linear-gradient(135deg, #2B5BBB 0%, #C2006D 100%)"
                    >
                        ✓ Se connecter
                    </button>

                    @if($errors->any())
                        <div class="p-4 rounded-lg text-white" style="background-color: #C2006D">
                            <p class="font-bold">❌ Erreur de connexion</p>
                            <ul class="mt-2 text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>

                <!-- Lien vers inscription -->
                <div class="px-8 py-6 bg-gray-50 border-t-2" style="border-color: #2BE7C6">
                    <p class="text-center text-gray-700">
                        Pas encore inscrit ?
                        <a href="{{ route('register') }}" class="font-bold transition-colors hover:opacity-80" style="color: #2B5BBB">
                            S'inscrire ici
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection