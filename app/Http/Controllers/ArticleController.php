<?php

namespace App\Http\Controllers;

use App\Models\Accessibilite;
use App\Models\Article;
use App\Models\Conclusion;
use App\Models\Rythme;
use App\Services\Article\ArticleService;
use App\Services\Article\LikeService;
use App\Services\Article\NotificationService;
use App\Services\Validation\ArticleValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $articleService;
    protected $likeService;
    protected $notificationService;
    protected $articleValidator;

    public function __construct(
        ArticleService $articleService,
        LikeService $likeService,
        NotificationService $notificationService,
        ArticleValidator $articleValidator
    ) {
        $this->articleService = $articleService;
        $this->likeService = $likeService;
        $this->notificationService = $notificationService;
        $this->articleValidator = $articleValidator;
    }

    /**
     * Page d'accueil : affiche les articles (derniers publiés)
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userId = auth()->check() ? auth()->id() : null;
        $query = $this->articleService->getArticlesQuery($userId);
        
        $articles = $query->inRandomOrder()->limit(6)->get();
        $articlesPlusVus = $this->articleService->getMostViewedArticles();
        $articlesPlusLikes = $this->articleService->getMostLikedArticles();
        
        // Créer la réponse avec le cookie si c'est la première visite
        $view = view('home', compact('articles', 'articlesPlusVus', 'articlesPlusLikes'));
        
        // Vérifier si le cookie n'existe pas déjà (première visite)
        if (!request()->hasCookie('okrina_visited')) {
            return response($view)->cookie(
                'okrina_visited', 
                'true', 
                60 * 24 * 30,
                '/', 
                null, 
                true,
                config('session.secure') || request()->secure()
            );
        }
        
        return $view;
    }

    /**
     * Afficher un article spécifique
     * 
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $article = Article::with([
            'editeur',
            'avis.user',
            'likes',
            'accessibilite',
            'conclusion',
            'rythme'
        ])->findOrFail($id);
        
        $article->increment('nb_vues');
        
        return view('articles.show', compact('article'));
    }
    
    /**
     * Gérer les likes/dislikes sur un article
     * 
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function like(string $id, Request $request)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();
        $nature = $request->input('nature');
        
        $result = $this->likeService->handleLike($article, $user, $nature);
        
        if (isset($result['error'])) {
            return back()->with('error', $result['message']);
        }
        
        return back()->with('success', $result['message']);
    }

    /**
     * Gérer les likes/dislikes (version toggle)
     * 
     * @param Request $request
     * @param string $articleId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function toggleLike(Request $request, string $articleId)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['error' => 'Vous devez être connecté pour aimer un article'], 401);
            }

            $user = auth()->user();
            $article = Article::findOrFail($articleId);
            $nature = $request->input('nature');
            
            $result = $this->likeService->toggleLike($article, $user, $nature);
            
            if (isset($result['error'])) {
                return response()->json(['error' => $result['message']], $result['code'] ?? 400);
            }
            
            return redirect()->back()->with('success', $result['message']);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Afficher le formulaire de création d'article
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $rythmes = Rythme::all();
        $accessibilites = Accessibilite::all();
        $conclusions = Conclusion::all();

        return view('articles.create', compact('rythmes', 'accessibilites', 'conclusions'));
    }

    /**
     * Stocker un nouvel article
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $isPublish = $request->has('action') && $request->action === 'publish';
        
        // Validation différente selon l'action
        $this->articleValidator->validateRequest($request, $isPublish, false);
        
        // Gestion des fichiers avec validation de sécurité
        $imagePath = $this->articleService->handleFileUpload(
            $request->file('image'),
            'articles/images',
            null,
            ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            ['jpg', 'jpeg', 'png', 'gif', 'webp']
        );
        
        $mediaPath = $this->articleService->handleFileUpload(
            $request->file('media'),
            'articles/media',
            null,
            ['audio/mpeg', 'audio/wav'],
            ['mp3', 'wav']
        );
        
        $article = Article::create([
            'titre' => $request->titre,
            'resume' => $request->resume ?? '',
            'texte' => $request->texte ?? '',
            'image' => $imagePath ?? '',
            'media' => $mediaPath ?? '',
            'user_id' => Auth::id(),
            'rythme_id' => $request->rythme_id ?? null,
            'accessibilite_id' => $request->accessibilite_id ?? null,
            'conclusion_id' => $request->conclusion_id ?? null,
            'en_ligne' => $isPublish,
        ]);
        
        // Envoyer des notifications aux suiveurs si publication
        if ($isPublish) {
            $this->notificationService->notifyFollowers($article);
        }
        
        $message = $isPublish ? 'Article publié avec succès !' : 'Brouillon enregistré avec succès !';
        
        return redirect()->route('articles.show', $article->id)
            ->with('success', $message);
    }
    


    /**
     * Filtrer les articles par accessibilité
     * 
     * @param Accessibilite $accessibilite
     * @return \Illuminate\View\View
     */
    public function byAccessibilite(Accessibilite $accessibilite)
    {
        $userId = auth()->check() ? auth()->id() : null;
        $articles = $this->articleService->filterByCharacteristic($accessibilite, 'accessibilite', $userId);
        
        return view('articles.by_characteristic', [
            'articles' => $articles,
            'characteristic' => $accessibilite,
            'type' => 'accessibilite'
        ]);
    }

    /**
     * Filtrer les articles par rythme
     * 
     * @param Rythme $rythme
     * @return \Illuminate\View\View
     */
    public function byRythme(Rythme $rythme)
    {
        $userId = auth()->check() ? auth()->id() : null;
        $articles = $this->articleService->filterByCharacteristic($rythme, 'rythme', $userId);
        
        return view('articles.by_characteristic', [
            'articles' => $articles,
            'characteristic' => $rythme,
            'type' => 'rythme'
        ]);
    }

    /**
     * Filtrer les articles par conclusion
     * 
     * @param Conclusion $conclusion
     * @return \Illuminate\View\View
     */
    public function byConclusion(Conclusion $conclusion)
    {
        $userId = auth()->check() ? auth()->id() : null;
        $articles = $this->articleService->filterByCharacteristic($conclusion, 'conclusion', $userId);
        
        return view('articles.by_characteristic', [
            'articles' => $articles,
            'characteristic' => $conclusion,
            'type' => 'conclusion'
        ]);
    }

    /**
     * Afficher le formulaire d'édition d'un article
     * 
     * @param Article $article
     * @return \Illuminate\View\View
     */
    public function edit(Article $article)
    {
        $this->checkArticleOwnership($article);

        $rythmes = Rythme::all();
        $accessibilites = Accessibilite::all();
        $conclusions = Conclusion::all();

        return view('articles.edit', compact('article', 'rythmes', 'accessibilites', 'conclusions'));
    }

    /**
     * Mettre à jour un article
     * 
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Article $article)
    {
        $this->checkArticleOwnership($article);

        $isPublish = $request->has('action') && $request->action === 'publish';
        $this->articleValidator->validateRequest($request, $isPublish, true);

        $data = $this->prepareArticleData($request, $article);
        
        // Gestion des fichiers avec validation de sécurité
        $data['image'] = $this->articleService->handleFileUpload(
            $request->file('image'),
            'articles/images',
            $article->image,
            ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            ['jpg', 'jpeg', 'png', 'gif', 'webp']
        ) ?? $article->image;
        
        $data['media'] = $this->articleService->handleFileUpload(
            $request->file('media'),
            'articles/media',
            $article->media,
            ['audio/mpeg', 'audio/wav'],
            ['mp3', 'wav']
        ) ?? $article->media;

        $article->update($data);

        $message = $isPublish ? 'Article publié avec succès !' : 'Brouillon mis à jour avec succès !';

        return redirect()->route('articles.show', $article->id)
            ->with('success', $message);
    }
    
    /**
     * Vérifie que l'utilisateur est propriétaire de l'article
     * 
     * @param Article $article
     * @return void
     */
    protected function checkArticleOwnership(Article $article): void
    {
        if (!$this->articleService->isArticleOwner($article, Auth::id())) {
            abort(403, 'Non autorisé');
        }
    }
    
    /**
     * Prépare les données pour la mise à jour d'un article
     * 
     * @param Request $request
     * @param Article $article
     * @return array
     */
    protected function prepareArticleData(Request $request, Article $article): array
    {
        return [
            'titre' => $request->titre,
            'resume' => $request->resume ?? $article->resume ?? '',
            'texte' => $request->texte ?? $article->texte ?? '',
            'rythme_id' => $request->rythme_id ?? $article->rythme_id ?? null,
            'accessibilite_id' => $request->accessibilite_id ?? $article->accessibilite_id ?? null,
            'conclusion_id' => $request->conclusion_id ?? $article->conclusion_id ?? null,
            'en_ligne' => $request->has('action') && $request->action === 'publish',
        ];
    }
    


    /**
     * Supprimer un article
     * 
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article)
    {
        $this->checkArticleOwnership($article);

        // Supprimer l'image et le média
        $this->articleService->handleFileUpload(null, 'articles/images', $article->image);
        $this->articleService->handleFileUpload(null, 'articles/media', $article->media);

        $article->delete();

        return redirect()->route('user.me')
            ->with('success', 'Article supprimé avec succès !');
    }
}
