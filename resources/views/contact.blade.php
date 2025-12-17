@extends('layout.app')

@section('contenu')
    <div class="max-w-4xl mx-auto px-5 py-12">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-8 text-center" style="background: linear-gradient(135deg, #2B5BBB 0%, #C2006D 100%)">
                <h1 class="text-4xl font-bold text-white mb-2">📞 Nous Contacter</h1>
                <p class="text-opacity-90 text-white">Avez-vous des questions ? Regardez notre vidéo de présentation</p>
            </div>

            <div class="p-8">
                <div class="p-6 mb-8 rounded" style="background-color: #2BE7C6; color: #2B5BBB">
                    <h2 class="text-2xl font-bold mb-4">🎥 Vidéo de présentation</h2>
                    <p class="mb-6">Découvrez notre plateforme et son fonctionnement à travers cette vidéo informative :</p>

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
                    <div class="border-2 rounded-lg p-6 text-center" style="border-color: #2BE7C6">
                        <div class="text-4xl mb-3">📧</div>
                        <h3 class="font-bold mb-2" style="color: #2B5BBB">Email</h3>
                        <p style="color: #2BE7C6">contact@marathon.local</p>
                    </div>

                    <div class="border-2 rounded-lg p-6 text-center" style="border-color: #C2006D">
                        <div class="text-4xl mb-3">📍</div>
                        <h3 class="font-bold mb-2" style="color: #C2006D">Adresse</h3>
                        <p style="color: #C2006D">IUT de Lens, France</p>
                    </div>

                    <div class="border-2 rounded-lg p-6 text-center" style="border-color: #2B5BBB">
                        <div class="text-4xl mb-3">⏰</div>
                        <h3 class="font-bold mb-2" style="color: #2B5BBB">Horaires</h3>
                        <p style="color: #2B5BBB">Lun - Ven: 9h-17h</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection