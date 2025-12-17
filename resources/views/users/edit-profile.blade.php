@extends('layout.app')

@section('contenu')
    <div class="max-w-2xl mx-auto p-5">
        <h1 class="text-4xl font-bold mb-8 text-gray-900">✏️ Modifier mon profil</h1>

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded">
                <strong class="text-red-900">❌ Erreurs :</strong>
                <ul class="mt-3 space-y-1 text-red-800">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">👤 Nom :</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">📧 Email :</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Avatar -->
            <div>
                <label for="avatar" class="block text-sm font-bold text-gray-700 mb-2">🖼️ Avatar :</label>
                @if($user->avatar)
                    <div class="mb-4 p-4 bg-gray-100 rounded-lg">
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar actuel" class="w-40 h-40 rounded-lg object-cover border-4 border-blue-500">
                        <p class="text-gray-600 text-sm mt-3">Avatar actuel</p>
                    </div>
                @endif
                <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <small class="text-gray-500 block mt-2">Formats acceptés : JPEG, PNG, GIF, WebP (max 2 Mo)</small>
            </div>

            <!-- Boutons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 text-white font-bold py-3 rounded-lg transition-opacity duration-200 hover:opacity-90" style="background-color: #2BE7C6; color: #2B5BBB">
                    💾 Enregistrer les modifications
                </button>
                <a href="{{ route('user.me') }}" class="flex-1 text-white font-bold py-3 rounded-lg transition-opacity duration-200 hover:opacity-90 flex items-center justify-center text-decoration-none" style="background-color: #C2006D">
                    ❌ Annuler
                </a>
            </div>
        </form>
    </div>
@endsection

