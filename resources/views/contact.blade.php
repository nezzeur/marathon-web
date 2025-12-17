@extends('layout.app')

@section('contenu')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Vidéo de présentation</h2>
            <div class="aspect-w-16 aspect-h-9">
                <iframe src="https://www.youtube.com/embed/yRBnlN_1Wek" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full rounded-lg"></iframe>
            </div>
        </div>
    </div>
    
    @include('components.footer')
@endsection