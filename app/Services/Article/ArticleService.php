<?php

namespace App\Services\Article;

use App\Models\Article;
use App\Services\FileManagement\FileUploadService;

class ArticleService
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Récupère les articles avec pagination et filtres
     * 
     * @param int|null $userId
     * @param bool $onlyOnline
     * @return mixed
     */
    public function getArticlesQuery(?int $userId = null, bool $onlyOnline = true)
    {
        $query = Article::query();
        
        if ($onlyOnline) {
            $query->where('en_ligne', true);
        }
        
        // Si l'utilisateur est connecté, on ajoute ses articles même hors ligne
        if ($userId) {
            $query->orWhere(function($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }
        
        return $query;
    }
    
    /**
     * Récupère les articles les plus vus
     * 
     * @param int $limit
     * @return mixed
     */
    public function getMostViewedArticles(int $limit = 3)
    {
        return Article::where('en_ligne', true)
            ->orderBy('nb_vues', 'desc')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Récupère les articles les plus likés
     * 
     * @param int $limit
     * @return mixed
     */
    public function getMostLikedArticles(int $limit = 3)
    {
        return Article::withCount('likes')
            ->where('en_ligne', true)
            ->orderBy('likes_count', 'desc')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Filtre les articles par caractéristique
     * 
     * @param mixed $characteristic
     * @param string $type
     * @param int|null $userId
     * @return mixed
     */
    public function filterByCharacteristic($characteristic, string $type, ?int $userId = null)
    {
        $query = Article::with(['editeur', 'accessibilite', 'rythme', 'conclusion'])
            ->where('en_ligne', true);
        
        // Filtrer par type de caractéristique
        switch ($type) {
            case 'accessibilite':
                $query->where('accessibilite_id', $characteristic->id);
                break;
            case 'rythme':
                $query->where('rythme_id', $characteristic->id);
                break;
            case 'conclusion':
                $query->where('conclusion_id', $characteristic->id);
                break;
        }
        
        // Si l'utilisateur est connecté, on ajoute ses articles même hors ligne
        if ($userId) {
            $query->orWhere(function($q) use ($userId, $characteristic, $type) {
                $q->where('user_id', $userId)
                  ->where($type . '_id', $characteristic->id);
            });
        }
        
        return $query->paginate(6);
    }
    
    /**
     * Gère l'upload et le stockage des fichiers avec validation de sécurité
     * 
     * @param UploadedFile|null $file
     * @param string $path
     * @param string|null $oldFile
     * @param array $allowedMimeTypes
     * @param array $allowedExtensions
     * @return string|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handleFileUpload(
        ?\Illuminate\Http\UploadedFile $file, 
        string $path, 
        ?string $oldFile = null,
        array $allowedMimeTypes = [],
        array $allowedExtensions = []
    ): ?string {
        return $this->fileUploadService->handleFileUpload($file, $path, $oldFile, $allowedMimeTypes, $allowedExtensions);
    }
    
    /**
     * Vérifie si l'utilisateur est propriétaire de l'article
     * 
     * @param Article $article
     * @param int $userId
     * @return bool
     */
    public function isArticleOwner(Article $article, int $userId): bool
    {
        return $article->user_id === $userId;
    }
}