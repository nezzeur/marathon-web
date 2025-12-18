@extends('layout.app')

@section('contenu')
    <style>
        .wiki-container {
            background: linear-gradient(135deg, rgba(13, 2, 33, 0.8) 0%, rgba(26, 5, 51, 0.6) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(43, 231, 198, 0.2);
            box-shadow: 0 0 20px rgba(43, 231, 198, 0.1);
        }
        

        
        .scanline-content {
            background-image: repeating-linear-gradient(
                to bottom,
                transparent 0px,
                rgba(43, 231, 198, 0.05) 1px,
                transparent 2px
            );
        }
        
        .resource-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(43, 231, 198, 0.2);
        }
        
        .resource-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(43, 231, 198, 0.15);
        }


        .pdf-container {
            position: relative;
            padding-bottom: 141.42%;
            height: 0;
            overflow: hidden;
            margin-bottom: 1rem;
            border: 2px solid var(--primary);
            border-radius: 8px;
            background-color: rgba(43, 231, 198, 0.05);
        }
        
        .pdf-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .pdf-toolbar {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }
        
        .team-section {
            background: linear-gradient(rgba(13, 2, 33, 0.9) 0%, rgba(26, 5, 51, 0.8) 100%);
            border: 1px solid rgba(43, 231, 198, 0.2);
            border-radius: 12px;
            overflow: hidden;
        }
        
        .team-photo-container {
            position: relative;
            height: 300px;
            overflow: hidden;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        .team-photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: grayscale(30%) brightness(0.8);
            transition: all 0.3s ease;
        }
        
        .team-photo-container:hover img {
            filter: grayscale(0%) brightness(1);
            transform: scale(1.05);
        }
        
        .team-member-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        
        .team-member-item {
            background: rgba(43, 231, 198, 0.05);
            border-left: 3px solid var(--primary);
            padding: 0.75rem 1rem;
            border-radius: 0 6px 6px 0;
            transition: all 0.3s ease;
        }
        
        .team-member-item:hover {
            background: rgba(43, 231, 198, 0.1);
            transform: translateX(5px);
            border-left: 3px solid rgba(43, 231, 198, 0.8);
        }
        
        .branch-section {
            margin-bottom: 1.5rem;
        }
        
        .branch-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(43, 231, 198, 0.3);
        }
        
        .branch-info {
            color: #3b82f6; /* Bleu pour INFO */
        }
        
        .branch-mmi {
            color: #ec4899; /* Rose pour MMI */
        }
        

    </style>

    <div class="max-w-6xl mx-auto p-5 wiki-container">
        <div class="bg-card rounded-lg shadow-lg shadow-primary/20 p-8 mb-8 border border-border">
            <h1 class="text-4xl font-bold text-foreground mb-2 chrome-text animate-glow-pulse">📚 Wiki Marathon</h1>
            <p class="text-muted-foreground mb-6">Bienvenue dans notre centre de ressources. Vous y trouverez des documents utiles et découvrirez notre équipe talentueuse.</p>
        </div>

        <div class="bg-card rounded-lg shadow-lg shadow-primary/20 overflow-hidden border border-border mb-8">
            <div class="border-b border-border">
                <div class="flex flex-wrap">
                    <button class="tab-btn flex-1 py-4 px-6 font-bold text-muted-foreground hover:bg-card/50 transition-colors border-b-4 border-transparent active" data-tab="pdf">
                        Documents PDF
                    </button>
                </div>
            </div>

            <div class="p-8 scanline-content">
                <div class="tab-content active" id="tab-pdf">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="resource-card bg-card/30 border border-border rounded-lg p-6">
                            <h3 class="text-xl font-bold text-primary mb-3">Charte Graphique</h3>

                            <div class="pdf-container">
                                <iframe src="{{ asset('storage/pdf/Charte_Graphique.pdf') }}#toolbar=0&navpanes=0&scrollbar=0" frameborder="0"></iframe>
                            </div>
                            
                            <div class="pdf-toolbar">
                                <a href="{{ asset('storage/pdf/Charte_Graphique.pdf') }}" target="_blank" class="inline-block font-mono text-xs px-3 py-2 bg-blue-500 text-white hover:brightness-110 border-b-2 border-blue-600/30 active:border-b-0 active:translate-y-0.5 transition-all">
                                    OUVRIR EN PLEIN ÉCRAN
                                </a>
                            </div>
                        </div>

                        <div class="resource-card bg-card/30 border border-border rounded-lg p-6">
                            <h3 class="text-xl font-bold text-primary mb-3">Article code musicaux des jeux vidéo</h3>
                            <div class="pdf-container">
                                <iframe src="{{ asset('storage/pdf/Article2_02.pdf') }}#toolbar=0&navpanes=0&scrollbar=0" frameborder="0"></iframe>
                            </div>
                            
                            <div class="pdf-toolbar">
                                <a href="{{ asset('storage/pdf/Article2_02.pdf') }}" target="_blank" class="inline-block font-mono text-xs px-3 py-2 bg-blue-500 text-white hover:brightness-110 border-b-2 border-blue-600/30 active:border-b-0 active:translate-y-0.5 transition-all">
                                    OUVRIR EN PLEIN ÉCRAN
                                </a>
                            </div>
                        </div>

                        <!-- PDF 3 -->
                        <div class="resource-card bg-card/30 border border-border rounded-lg p-6">
                            <h3 class="text-xl font-bold text-primary mb-3">Article Sonic Colors</h3>

                            <div class="pdf-container">
                                <iframe src="{{ asset('storage/pdf/Article2_01.pdf') }}#toolbar=0&navpanes=0&scrollbar=0" frameborder="0"></iframe>
                            </div>
                            
                            <div class="pdf-toolbar">
                                <a href="{{ asset('storage/pdf/Article2_01.pdf') }}" target="_blank" class="inline-block font-mono text-xs px-3 py-2 bg-blue-500 text-white hover:brightness-110 border-b-2 border-blue-600/30 active:border-b-0 active:translate-y-0.5 transition-all">
                                    OUVRIR EN PLEIN ÉCRAN
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="bg-card rounded-lg shadow-lg shadow-primary/20 overflow-hidden border border-border mb-8 team-section">
            <div class="border-b border-border">
                <div class="flex flex-wrap">
                    <button class="tab-btn flex-1 py-4 px-6 font-bold text-muted-foreground hover:bg-card/50 transition-colors border-b-4 border-transparent active" data-tab="team">
                        Notre Équipe
                    </button>
                </div>
            </div>

            <div class="p-8 scanline-content">
                <div class="tab-content active" id="tab-team">
                    <h2 class="text-2xl font-bold text-primary mb-6">L'équipe Marathon</h2>
                    <p class="text-muted-foreground mb-6">Découvrez les membres talentueux qui composent notre équipe de développement.</p>

                    <!-- Photo de paysage -->
                    <div class="team-photo-container mb-6">
                        <img src="{{ asset('storage/images/groupe.jpg') }}" alt="Photo d'équipe en paysage">
                    </div>

                    <h3 class="text-xl font-bold text-primary mb-4">Membres de l'équipe :</h3>

                    <!-- Branche INFO -->
                    <div class="branch-section">
                        <div class="branch-title">
                            <span class="font-bold branch-info">INFORMATIQUE</span>
                        </div>
                        <div class="team-member-list">
                            <div class="team-member-item">
                                <span class="text-foreground font-medium">Baillet Quentin</span>
                            </div>
                            <div class="team-member-item">
                                <span class="text-foreground font-medium">Blanchard Luka</span>
                            </div>
                            <div class="team-member-item">
                                <span class="text-foreground font-medium">Huyghe Neo</span>
                            </div>
                            <div class="team-member-item">
                                <span class="text-foreground font-medium">Peru Noa</span>
                            </div>
                        </div>
                    </div>

                    <div class="branch-section">
                        <div class="branch-title">
                            <span class="font-bold branch-mmi">MMI</span>
                        </div>
                        <div class="team-member-list">
                            <div class="team-member-item">
                                <span class="text-foreground font-medium">Delannoy Lola</span>
                            </div>
                            <div class="team-member-item">
                                <span class="text-foreground font-medium">Caudron Erwan</span>
                            </div>
                            <div class="team-member-item">
                                <span class="text-foreground font-medium">Salmi Kenza</span>
                            </div>
                            <div class="team-member-item">
                                <span class="text-foreground font-medium">Coustenoble Anélie</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('contact') }}" class="inline-block font-mono text-xs px-4 py-3 bg-primary text-primary-foreground hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1">
            ← RETOUR AU CONTACT
        </a>
    </div>

    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Retirer la classe active de tous les boutons
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active');
                    b.classList.add('text-muted-foreground');
                });

                // Masquer tous les onglets
                document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));

                // Ajouter la classe active au bouton cliqué
                this.classList.add('active');
                this.classList.remove('text-muted-foreground');
                this.classList.add('text-primary');

                // Afficher le contenu correspondant
                const tabId = 'tab-' + this.getAttribute('data-tab');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });
    </script>
@endsection