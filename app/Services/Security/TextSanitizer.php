<?php

namespace App\Services\Security;

use HTMLPurifier;
use HTMLPurifier_Config;

class TextSanitizer
{
    protected HTMLPurifier $purifier;

    public function __construct()
    {
        $this->configurePurifier();
    }

    /**
     * Configure HTML Purifier avec des règles de sécurité strictes pour le texte simple
     */
    protected function configurePurifier(): void
    {
        $config = HTMLPurifier_Config::createDefault();

        $config->set('Cache.DefinitionImpl', null);
        
        // Configuration de sécurité pour le texte simple
        $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
        $config->set('HTML.Allowed', 'p,b,strong,i,em,u,s,del,ins,a[href|title],br');
        $config->set('HTML.SafeIframe', false);
        $config->set('HTML.SafeObject', false);
        $config->set('HTML.SafeEmbed', false);
        $config->set('Output.FlashCompat', false);
        $config->set('HTML.ForbiddenAttributes', ['style', 'onclick', 'ondblclick', 'onmouseover', 'onmouseout', 'onload', 'onunload', 'onfocus', 'onblur', 'onchange', 'onsubmit', 'onreset', 'onselect', 'onkeypress', 'onkeydown', 'onkeyup']);
        $config->set('HTML.SafeScripting', []);
        $config->set('URI.SafeIframeRegexp', '%^%'); // Désactive les iframes
        
        // Configuration URI pour bloquer les protocoles dangereux
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
        $config->set('URI.DisableExternal', false);
        $config->set('URI.DisableExternalResources', false);
        
        // Configuration pour les attributs
        $config->set('Attr.AllowedFrameTargets', []);
        $config->set('Attr.EnableID', true);
        
        // Configuration pour les scripts
        $config->set('HTML.Trusted', false);
        
        $this->purifier = new HTMLPurifier($config);
    }

    /**
     * Désinfecte le texte simple
     * 
     * @param string $text
     * @return string
     */
    public function sanitize(string $text): string
    {
        if (empty(trim($text))) {
            return '';
        }
        
        // Désinfection basique avant HTML Purifier
        $text = $this->basicSanitize($text);
        
        // Désinfection avec HTML Purifier
        return $this->purifier->purify($text);
    }

    /**
     * Désinfection basique avant HTML Purifier
     * 
     * @param string $text
     * @return string
     */
    protected function basicSanitize(string $text): string
    {
        // Supprimer les scripts et balises dangereuses
        $text = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $text);
        $text = preg_replace('/<iframe\b[^>]*>.*?<\/iframe>/is', '', $text);
        $text = preg_replace('/<object\b[^>]*>.*?<\/object>/is', '', $text);
        $text = preg_replace('/<embed\b[^>]*>.*?<\/embed>/is', '', $text);
        $text = preg_replace('/<form\b[^>]*>.*?<\/form>/is', '', $text);
        
        // Supprimer les balises HTML vides dangereuses
        $text = preg_replace('/<script\b[^>]*\/>/is', '', $text);
        $text = preg_replace('/<iframe\b[^>]*\/>/is', '', $text);
        $text = preg_replace('/<object\b[^>]*\/>/is', '', $text);
        $text = preg_replace('/<embed\b[^>]*\/>/is', '', $text);
        $text = preg_replace('/<form\b[^>]*\/>/is', '', $text);
        
        // Supprimer les attributs dangereux
        $text = preg_replace('/(\w+)\s*=\s*["\']\s*javascript:[^"\']*["\']/is', '$1="#"', $text);
        $text = preg_replace('/(\w+)\s*=\s*["\']\s*vbscript:[^"\']*["\']/is', '$1="#"', $text);
        $text = preg_replace('/(\w+)\s*=\s*["\']\s*data:[^"\']*["\']/is', '$1="#"', $text);
        
        // Supprimer les event handlers
        $text = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/is', '', $text);
        
        return trim($text);
    }

    /**
     * Désinfecte et convertit les sauts de ligne en balises <br>
     * 
     * @param string $text
     * @return string
     */
    public function sanitizeWithLineBreaks(string $text): string
    {
        $sanitized = $this->sanitize($text);
        // Convertir les sauts de ligne en balises <br> sécurisées
        return nl2br($sanitized);
    }
}