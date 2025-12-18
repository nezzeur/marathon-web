@extends('layout.app')

@section('contenu')

    {{-- 1. BACKGROUND --}}
    <div class="fixed inset-0 z-0 overflow-hidden bg-[#050505]">
        <img
                src="{{ asset('images/bannière.png') }}"
                alt="Synthwave Grid"
                class="absolute inset-0 w-full h-full object-cover object-bottom bg-animate opacity-90"
        >
        {{-- Overlay léger --}}
        <div class="absolute inset-0 bg-blue-900/10 mix-blend-overlay"></div>
    </div>

    {{-- 2. CONTENU PRINCIPAL --}}
    <div class="relative z-10 min-h-screen py-10 px-4 flex justify-center">

        <div class="w-full max-w-5xl">

            {{-- EN-TÊTE --}}
            <div class="mb-10 text-center">
                <h1 class="text-4xl md:text-5xl font-black italic uppercase tracking-tighter text-white drop-shadow-[0_2px_0px_#2B5BBB]">
                    NOUVEL ARTICLE
                </h1>
                <div class="h-1 w-32 mx-auto mt-4 bg-gradient-to-r from-transparent via-[#C2006D] to-transparent"></div>
            </div>

            {{-- BOITE D'INFO (Texte Blanc) --}}
            <div class="mb-8 p-6 rounded-xl border border-[#2B5BBB]/50 bg-[#2B5BBB]/20 backdrop-blur-md shadow-[0_0_20px_rgba(43,91,187,0.2)] flex flex-col md:flex-row gap-4 items-start">
                <div>
                    <h3 class="text-white font-bold uppercase mb-2 text-sm tracking-widest" style="font-family: 'VT323', monospace; font-size: 1.5rem;">Protocoles d'enregistrement</h3>
                    <ul class="space-y-2 text-white text-xs md:text-sm font-sans">
                        <li class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#C2006D] shadow-[0_0_5px_#C2006D]"></span>
                            <strong>PUBLIER :</strong> Visible sur le réseau global (Tous les champs requis).
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#2BE7C6] shadow-[0_0_5px_#2BE7C6]"></span>
                            <strong>BROUILLON :</strong> Sauvegarde locale (Titre requis uniquement).
                        </li>
                    </ul>
                </div>
            </div>

            {{-- FORMULAIRE --}}
            <form id="articleForm" action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="relative group">
                @csrf

                {{-- Cadre principal --}}
                <div class="relative bg-gradient-to-br from-[#2B5BBB]/30 to-[#051025]/80 backdrop-blur-xl rounded-2xl border border-[#2BE7C6]/30 p-8 shadow-[0_0_50px_rgba(43,91,187,0.2)]">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        {{-- COLONNE GAUCHE --}}
                        <div class="lg:col-span-2 space-y-6">

                            <div class="group/field neon-focus-cyan rounded-xl bg-[#051025]/40 border border-[#2B5BBB]/30 p-1 transition-all">
                                <label for="titre" class="block text-xs font-bold text-white px-3 pt-2 uppercase tracking-widest"> Titre de l'article</label>
                                <input type="text" name="titre" id="titre" value="{{ old('titre') }}" required
                                       class="w-full px-3 py-2 bg-transparent border-none text-white placeholder-gray-400 focus:ring-0 text-lg font-bold"
                                       style="font-family: 'VT323', monospace; font-size: 1.5rem;"
                                       placeholder="Entrez le titre...">
                                @error('titre') <p class="text-[#C2006D] text-xs px-3 pb-2 font-bold animate-pulse"> {{ $message }}</p> @enderror
                            </div>

                            <div class="group/field neon-focus-cyan rounded-xl bg-[#051025]/40 border border-[#2B5BBB]/30 p-1 transition-all">
                                <label for="resume" class="block text-xs font-bold text-white px-3 pt-2 uppercase tracking-widest">Résumé (Markdown)</label>
                                <textarea name="resume" id="resume" rows="3"
                                          class="w-full px-3 py-2 bg-transparent border-none text-white placeholder-gray-400 focus:ring-0 text-sm font-sans"
                                          placeholder="Accroche courte...">{{ old('resume') }}</textarea>
                                @error('resume') <p class="text-[#C2006D] text-xs px-3 pb-2 font-bold"> {{ $message }}</p> @enderror
                            </div>

                            <div class="group/field neon-focus-pink rounded-xl bg-[#051025]/40 border border-[#2B5BBB]/30 p-1 transition-all">
                                <label for="texte" class="block text-xs font-bold text-white px-3 pt-2 uppercase tracking-widest">Contenu (Markdown)</label>
                                <textarea name="texte" id="texte" rows="12"
                                          class="w-full px-3 py-2 bg-transparent border-none text-white placeholder-gray-400 focus:ring-0 text-sm font-sans"
                                          placeholder="Rédigez votre article ici...">{{ old('texte') }}</textarea>
                                @error('texte') <p class="text-[#C2006D] text-xs px-3 pb-2 font-bold">{ $message }}</p> @enderror
                            </div>

                        </div>

                        {{-- COLONNE DROITE --}}
                        <div class="space-y-6">

                            <div class="p-4 rounded-xl border border-[#2BE7C6]/20 bg-[#2BE7C6]/5 hover:bg-[#2BE7C6]/10 transition-colors">
                                <label for="image" class="block text-xs font-bold text-white mb-3 uppercase tracking-wider">Image de couverture</label>
                                <input type="file" name="image" id="image" accept="image/*" class="w-full text-xs text-white file:text-white">
                                @error('image') <p class="text-[#C2006D] text-xs mt-2 font-bold">{ $message }}</p> @enderror
                            </div>

                            <div class="p-4 rounded-xl border border-[#C2006D]/20 bg-[#C2006D]/5 hover:bg-[#C2006D]/10 transition-colors">
                                <label for="media" class="block text-xs font-bold text-white mb-3 uppercase tracking-wider">Fichier Audio</label>
                                <input type="file" name="media" id="media" accept=".mp3,.wav" class="w-full text-xs text-white file:text-white">
                                @error('media') <p class="text-[#C2006D] text-xs mt-2 font-bold"> {{ $message }}</p> @enderror
                            </div>

                            <hr class="border-[#2B5BBB]/30">

                            <div class="space-y-4">
                                @foreach(['rythme_id' => 'Rythme', 'accessibilite_id' => 'Accessibilité', 'conclusion_id' => 'Conclusion'] as $field => $label)
                                    <div>
                                        <label class="text-[10px] text-white uppercase font-bold">{{ $label }}</label>
                                        <select name="{{ $field }}" id="{{ $field }}" class="w-full mt-1 bg-[#051025]/60 border border-[#2B5BBB]/50 rounded-lg text-white text-xs py-2 px-3 focus:border-[#2BE7C6] focus:ring-1 focus:ring-[#2BE7C6]">
                                            <option value="">-- SÉLECTIONNER --</option>
                                            {{-- Boucle PHP (à adapter selon tes variables) --}}
                                            @if($field == 'rythme_id') @foreach($rythmes as $r) <option value="{{ $r->id }}">{{ $r->texte }}</option> @endforeach @endif
                                            @if($field == 'accessibilite_id') @foreach($accessibilites as $a) <option value="{{ $a->id }}">{{ $a->texte }}</option> @endforeach @endif
                                            @if($field == 'conclusion_id') @foreach($conclusions as $c) <option value="{{ $c->id }}">{{ $c->texte }}</option> @endforeach @endif
                                        </select>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    {{-- ACTIONS (BOUTONS STYLE ARCADE START) --}}
                    <div class="mt-8 pt-6 border-t border-[#2B5BBB]/30 flex flex-col md:flex-row gap-4 items-center">

                        {{-- Bouton PUBLIER (Cyan #2BE7C6 - Style Arcade) --}}
                        <button type="submit" name="action" value="publish" onclick="setRequired(true)"
                                class="flex-1 w-full font-mono text-xs px-4 py-3 text-black hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1 transition-all"
                                style="background-color: #2BE7C6;">
                             PUBLIER L'ARTICLE
                        </button>

                        {{-- Bouton BROUILLON (Rose #C2006D - Style Arcade) --}}
                        <button type="submit" name="action" value="draft" onclick="setRequired(false)"
                                class="flex-1 w-full font-mono text-xs px-4 py-3 text-white hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1 transition-all"
                                style="background-color: #C2006D;">
                             SAUVEGARDER BROUILLON
                        </button>
                    </div>

                    <div class="absolute -top-1 -left-1 w-6 h-6 border-t-2 border-l-2 border-[#2BE7C6] opacity-80"></div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 border-b-2 border-r-2 border-[#2BE7C6] opacity-80"></div>
                    <div class="absolute -top-1 -right-1 w-6 h-6 border-t-2 border-r-2 border-[#C2006D] opacity-80"></div>
                    <div class="absolute -bottom-1 -left-1 w-6 h-6 border-b-2 border-l-2 border-[#C2006D] opacity-80"></div>

                </div>
            </form>
        </div>
    </div>

    <script>
        function setRequired(isPublish) {
            const fields = ['resume', 'texte', 'image', 'media', 'rythme_id', 'accessibilite_id', 'conclusion_id'];
            fields.forEach(id => {
                const el = document.getElementById(id);
                if(el) el.required = isPublish;
            });
            document.getElementById('titre').required = true;
        }
    </script>
@endsection