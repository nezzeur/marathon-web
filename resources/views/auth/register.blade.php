@extends("layout.app")

@section('contenu')
    <div class="min-h-screen flex items-center justify-center px-4 py-12" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%)">
        <div class="w-full max-w-md">
            <!-- Carte d'inscription -->
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
                <!-- En-tête -->
                <div class="p-8 text-center" style="background: linear-gradient(135deg, #2BE7C6 0%, #2B5BBB 100%)">
                    <h1 class="text-4xl font-bold text-white mb-2">📝 Inscription</h1>
                    <p class="text-opacity-90 text-white">Rejoignez Marathon aujourd'hui</p>
                </div>

                <!-- Formulaire -->
                <form action="{{ route('register') }}" method="post" class="p-8 space-y-6">
                    @csrf

                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">👤 Nom d'utilisateur</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            required
                            placeholder="Votre nom"
                            class="w-full px-4 py-3 border-2 rounded-lg focus:outline-none focus:ring-0 transition-colors"
                            style="border-color: #2BE7C6"
                            value="{{ old('name') }}"
                        />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

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
                            style="border-color: #2BE7C6"
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

                    <!-- Confirmation mot de passe -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">🔐 Confirmer le mot de passe</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-3 border-2 rounded-lg focus:outline-none focus:ring-0 transition-colors"
                            style="border-color: #2BE7C6"
                        />
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bouton d'inscription -->
                    <button
                        type="submit"
                        class="w-full font-bold py-3 rounded-lg text-white text-lg transition-opacity hover:opacity-90"
                        style="background: linear-gradient(135deg, #2BE7C6 0%, #2B5BBB 100%); color: white"
                    >
                        ✓ S'inscrire
                    </button>

                    @if($errors->any())
                        <div class="p-4 rounded-lg text-white" style="background-color: #C2006D">
                            <p class="font-bold">❌ Erreur lors de l'inscription</p>
                            <ul class="mt-2 text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>

                <!-- Lien vers connexion -->
                <div class="px-8 py-6 bg-gray-50 border-t-2" style="border-color: #2BE7C6">
                    <p class="text-center text-gray-700">
                        Déjà un compte ?
                        <a href="{{ route('login') }}" class="font-bold transition-colors hover:opacity-80" style="color: #2B5BBB">
                            Se connecter ici
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
