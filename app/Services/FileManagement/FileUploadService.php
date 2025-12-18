<?php

namespace App\Services\FileManagement;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FileUploadService
{
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
        ?UploadedFile $file, 
        string $path, 
        ?string $oldFile = null,
        array $allowedMimeTypes = [],
        array $allowedExtensions = []
    ): ?string {
        // Supprimer l'ancien fichier si nécessaire
        if ($oldFile && Storage::exists('public/' . $oldFile)) {
            Storage::delete('public/' . $oldFile);
        }
        
        // Si aucun fichier n'est fourni, retourner null
        if (!$file) {
            return null;
        }
        
        // Validation du fichier
        $this->validateFileUpload($file, $allowedMimeTypes, $allowedExtensions);
        
        // Générer un nom de fichier sécurisé
        $safeFilename = $this->generateSafeFilename($file);
        
        // Stocker le fichier avec le nom sécurisé
        $storedPath = $file->storeAs($path, $safeFilename, 'public');
        
        return $storedPath;
    }

    /**
     * Valide un fichier uploadé selon des critères de sécurité stricts
     * 
     * @param UploadedFile $file
     * @param array $allowedMimeTypes
     * @param array $allowedExtensions
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateFileUpload(UploadedFile $file, array $allowedMimeTypes, array $allowedExtensions): void
    {
        // Vérifier que le fichier est valide
        if (!$file->isValid()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'file' => 'Le fichier uploadé n\'est pas valide.'
            ]);
        }
        
        // Vérifier la taille du fichier (max 10MB par défaut)
        $maxSize = 10 * 1024 * 1024; // 10MB
        if ($file->getSize() > $maxSize) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'file' => 'Le fichier est trop volumineux. Taille maximale: 10MB.'
            ]);
        }
        
        // Vérifier le type MIME réel du fichier
        $detectedMimeType = $file->getMimeType();
        
        if (!empty($allowedMimeTypes) && !in_array($detectedMimeType, $allowedMimeTypes)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'file' => 'Type de fichier non autorisé. Types autorisés: ' . implode(', ', $allowedMimeTypes)
            ]);
        }
        
        // Vérifier l'extension du fichier
        $extension = strtolower($file->getClientOriginalExtension());
        
        if (!empty($allowedExtensions) && !in_array($extension, $allowedExtensions)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'file' => 'Extension de fichier non autorisée. Extensions autorisées: ' . implode(', ', $allowedExtensions)
            ]);
        }
        
        // Bloquer les fichiers potentiellement dangereux
        $dangerousExtensions = ['php', 'php3', 'php4', 'php5', 'phtml', 'pl', 'py', 'rb', 'sh', 'cgi', 'exe', 'bat', 'cmd'];
        if (in_array($extension, $dangerousExtensions)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'file' => 'Ce type de fichier est interdit pour des raisons de sécurité.'
            ]);
        }
        
        // Vérification supplémentaire du contenu pour les images
        if (str_starts_with($detectedMimeType, 'image/')) {
            $this->validateImageContent($file);
        }
    }

    /**
     * Valide le contenu réel d'une image pour éviter les fichiers malveillants
     * 
     * @param UploadedFile $file
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateImageContent(UploadedFile $file): void
    {
        try {
            // Vérifier les dimensions de l'image
            $imageInfo = getimagesize($file->getRealPath());
            
            if ($imageInfo === false) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'file' => 'Le fichier n\'est pas une image valide.'
                ]);
            }
            
            // Vérifier que le type MIME détecté correspond à l'extension
            $detectedMime = $imageInfo['mime'];
            $allowedImageMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            
            if (!in_array($detectedMime, $allowedImageMimes)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'file' => 'Format d\'image non supporté.'
                ]);
            }
            
            // Limiter les dimensions de l'image
            $maxWidth = 5000;
            $maxHeight = 5000;
            
            if ($imageInfo[0] > $maxWidth || $imageInfo[1] > $maxHeight) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'file' => 'Les dimensions de l\'image sont trop grandes. Maximum: ' . $maxWidth . 'x' . $maxHeight . ' pixels.'
                ]);
            }
            
        } catch (\Exception $e) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'file' => 'Impossible de valider le contenu de l\'image.'
            ]);
        }
    }

    /**
     * Génère un nom de fichier sécurisé
     * 
     * @param UploadedFile $file
     * @return string
     */
    protected function generateSafeFilename(UploadedFile $file): string
    {
        // Obtenir l'extension originale (sécurisée)
        $extension = strtolower($file->getClientOriginalExtension());
        
        // Générer un nom de fichier unique et sécurisé
        $safeName = md5(uniqid() . time()) . '.' . $extension;
        
        return $safeName;
    }
}