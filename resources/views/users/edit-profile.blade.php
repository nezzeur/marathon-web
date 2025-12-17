@extends('layout.app')

@section('contenu')
    <div class="max-w-2xl mx-auto p-5">
        <h1 class="mb-8">Modifier mon profil</h1>

        @if($errors->any())
            <div class="p-4 rounded-md mb-5 bg-red-100 text-red-900 border border-red-300">
                <strong>Erreurs :</strong>
                <ul class="m-2.5 ml-5 p-0">
                    @foreach($errors->all() as $error)
                        <li class="my-1.5">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-8 rounded-lg border border-gray-300 mb-7">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="name" class="block mb-2 font-bold text-gray-800">Nom :</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-2.5 py-2.5 border border-gray-300 rounded-md text-base box-border font-sans focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
            </div>

            <div class="mb-5">
                <label for="email" class="block mb-2 font-bold text-gray-800">Email :</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-2.5 py-2.5 border border-gray-300 rounded-md text-base box-border font-sans focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
            </div>

            <div class="mb-5">
                <label for="avatar" class="block mb-2 font-bold text-gray-800">Avatar :</label>
                @if($user->avatar)
                    <div class="mb-4 p-4 bg-white border border-gray-300 rounded-md">
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar actuel" class="w-48 h-48 rounded-md block mb-2.5 object-cover border-2 border-blue-600">
                        <p class="text-gray-400 text-sm mt-2">Avatar actuel</p>
                    </div>
                @endif
                <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp" class="w-full px-2.5 py-2.5 border border-gray-300 rounded-md text-base box-border font-sans focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200">
                <small class="block mt-2 text-gray-600 text-sm">Formats acceptés : JPEG, PNG, GIF, WebP (max 2 Mo)</small>
            </div>

            <div class="flex gap-2.5 mt-7 mb-12">
                <button type="submit" class="inline-block px-5 py-2.5 rounded-md text-decoration-none font-bold transition-colors duration-200 border-0 cursor-pointer text-base bg-blue-600 text-white hover:bg-blue-700">Enregistrer les modifications</button>
                <a href="{{ route('user.me') }}" class="inline-block px-5 py-2.5 rounded-md text-decoration-none font-bold transition-colors duration-200 border-0 cursor-pointer text-base bg-gray-500 text-white hover:bg-gray-600">Annuler</a>
            </div>
        </form>
    </div>
@endsection

