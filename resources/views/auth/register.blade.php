@extends("layout.app")

@section('contenu')
    {{-- Fond Grille 3D avec variables CSS --}}
    <div class="fixed inset-0 z-0 pointer-events-none bg-background">
    </div>

    <!-- Grid Floor -->
    <div class="fixed bottom-0 left-0 right-0 h-[45vh] z-0 pointer-events-none opacity-40"
         style="
            background-image:
                linear-gradient(0deg, transparent 24%, var(--border) 25%, var(--border) 26%, transparent 27%, transparent 74%, var(--border) 75%, var(--border) 76%, transparent 77%, transparent),
                linear-gradient(90deg, transparent 24%, var(--border) 25%, var(--border) 26%, transparent 27%, transparent 74%, var(--border) 75%, var(--border) 76%, transparent 77%, transparent);
            background-size: 50px 50px;
            perspective: 1000px;
            transform: perspective(500px) rotateX(60deg) translateY(100px) scale(2);
         ">
    </div>

    {{-- Contenu Principal avec layout min-h --}}


                    <!-- Colonne droite : Formulaire d'inscription -->
                    <div class="md:w-1/2 order-1 md:order-2 w-full">
                        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-2" style="border-color: #2BE7C6; backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.98)">
                            <!-- En-tête avec gradient retro -->
                            <div class="p-8 text-center" style="background: linear-gradient(135deg, #2BE7C6 0%, #2B5BBB 100%); box-shadow: 0 8px 32px rgba(43, 91, 187, 0.2)">
                                <h3 class="text-6xl font-black text-white mb-3">📝</h3>
                                <h2 class="text-4xl font-black text-white mb-2">INSCRIPTION</h2>
                                <p class="text-white text-opacity-90 font-bold text-lg">Créez votre compte Marathon</p>
                            </div>

                            <!-- Formulaire -->
                            <form action="{{ route('register') }}" method="post" class="p-8 space-y-6">
                                @csrf

                                <!-- Nom -->
                                <div>
                                    <label for="name" class="block text-sm font-black text-gray-800 mb-3 uppercase tracking-wide" style="color: #2B5BBB">👤 Nom d'utilisateur</label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        required
                                        placeholder="Votre nom"
                                        class="w-full px-5 py-4 border-2 rounded-xl focus:outline-none focus:ring-0 transition-all font-semibold text-base"
                                        style="border-color: #2BE7C6"
                                        value="{{ old('name') }}"
                                    />
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-2 font-bold">❌ {{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-black text-gray-800 mb-3 uppercase tracking-wide" style="color: #2B5BBB">📧 Email</label>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        required
                                        placeholder="votre@email.com"
                                        class="w-full px-5 py-4 border-2 rounded-xl focus:outline-none focus:ring-0 transition-all font-semibold text-base"
                                        style="border-color: #2BE7C6"
                                        value="{{ old('email') }}"
                                    />
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-2 font-bold">❌ {{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mot de passe -->
                                <div>
                                    <label for="password" class="block text-sm font-black text-gray-800 mb-3 uppercase tracking-wide" style="color: #2B5BBB">🔑 Mot de passe</label>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        required
                                        placeholder="••••••••"
                                        class="w-full px-5 py-4 border-2 rounded-xl focus:outline-none focus:ring-0 transition-all font-semibold text-base"
                                        style="border-color: #2BE7C6"
                                    />
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-2 font-bold">❌ {{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirmation mot de passe -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-black text-gray-800 mb-3 uppercase tracking-wide" style="color: #2B5BBB">🔐 Confirmer</label>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        required
                                        placeholder="••••••••"
                                        class="w-full px-5 py-4 border-2 rounded-xl focus:outline-none focus:ring-0 transition-all font-semibold text-base"
                                        style="border-color: #2BE7C6"
                                    />
                                    @error('password_confirmation')
                                        <p class="text-red-500 text-sm mt-2 font-bold">❌ {{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Bouton d'inscription -->
                                <button
                                    type="submit"
                                    class="w-full font-black py-5 rounded-xl text-white text-lg transition-all hover:scale-105 duration-200 uppercase shadow-lg font-orbitron tracking-wide"
                                    style="background: linear-gradient(135deg, #2BE7C6 0%, #2B5BBB 100%); box-shadow: 0 4px 20px rgba(43, 91, 187, 0.3); color: white"
                                >
                                    ✓ S'INSCRIRE
                                </button>

                                @if($errors->any())
                                    <div class="p-5 rounded-xl text-white space-y-2" style="background-color: #C2006D; box-shadow: 0 4px 15px rgba(194, 0, 109, 0.2)">
                                        <p class="font-black text-base">❌ ERREUR D'INSCRIPTION</p>
                                        <ul class="text-sm space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>• {{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </form>

                            <!-- Lien vers connexion -->
                            <div class="px-8 py-6 bg-gray-50 border-t-2" style="border-color: #2BE7C6">
                                <p class="text-center text-gray-700 font-bold text-base">
                                    Vous avez déjà un compte ?
                                    <a href="{{ route('login') }}" class="transition-all hover:scale-105 duration-200 font-black" style="color: #2B5BBB">
                                        Se connecter ici
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

