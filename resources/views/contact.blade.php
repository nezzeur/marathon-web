@extends('layout.app')

@section('contenu')
    <div class="max-w-4xl mx-auto px-5 py-12">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8 text-center">
                <h1 class="text-4xl font-bold text-white mb-2">📞 Nous Contacter</h1>
                <p class="text-blue-100">Avez-vous des questions ? Regardez notre vidéo de présentation</p>
            </div>

            <div class="p-8">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8 rounded">
                    <h2 class="text-2xl font-bold text-blue-900 mb-4">🎥 Vidéo de présentation</h2>
                    <p class="text-blue-800 mb-6">Découvrez notre plateforme et son fonctionnement à travers cette vidéo informative :</p>

                    <div class="aspect-video bg-black rounded-lg overflow-hidden shadow-lg">
                        <iframe
                            src="https://www.youtube.com/embed/yRBnlN_1Wek"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            class="w-full h-full">
                        </iframe>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                        <div class="text-4xl mb-3">📧</div>
                        <h3 class="font-bold text-green-900 mb-2">Email</h3>
                        <p class="text-green-800 text-sm">contact@marathon.local</p>
                    </div>

                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 text-center">
                        <div class="text-4xl mb-3">📍</div>
                        <h3 class="font-bold text-purple-900 mb-2">Adresse</h3>
                        <p class="text-purple-800 text-sm">IUT de Lens, France</p>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                        <div class="text-4xl mb-3">⏰</div>
                        <h3 class="font-bold text-yellow-900 mb-2">Horaires</h3>
                        <p class="text-yellow-800 text-sm">Lun - Ven: 9h-17h</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection