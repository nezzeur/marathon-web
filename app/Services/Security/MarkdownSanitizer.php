<?php

namespace App\Services\Security;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use League\CommonMark\Extension\CommonMark\Node\Inline\Emphasis;
use League\CommonMark\Extension\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote;
use League\CommonMark\Extension\CommonMark\Node\Block\HtmlBlock;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\CommonMark\Node\Block\HorizontalRule;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Newline;
use League\CommonMark\Extension\CommonMark\Node\Inline\Text;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverterInterface;
use HTMLPurifier;
use Illuminate\Support\HtmlString;

class MarkdownSanitizer
{
    protected HTMLPurifier $purifier;
    protected MarkdownConverterInterface $converter;

    public function __construct()
    {
        $this->configurePurifier();
        $this->configureMarkdownConverter();
    }

    /**
     * Configure HTML Purifier avec des règles de sécurité strictes
     */
    protected function configurePurifier(): void
    {
        $config = \HTMLPurifier_Config::createDefault();

        // Désactiver le cache pour éviter les problèmes de permissions
        $config->set('Cache.DefinitionImpl', null);

        // Configuration de sécurité
        $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
        $config->set('HTML.Allowed', 'p,b,strong,i,em,u,s,del,ins,h1,h2,h3,h4,h5,h6,ul,ol,li,a[href|title],img[src|alt|title|width|height],blockquote,code,pre[class],table,thead,tbody,tr,th,td,hr');
        $config->set('HTML.SafeIframe', false);
        $config->set('HTML.SafeObject', false);
        $config->set('HTML.SafeEmbed', false);
        $config->set('Output.FlashCompat', false);
        $config->set('HTML.ForbiddenAttributes', ['style', 'onclick', 'ondblclick', 'onmouseover', 'onmouseout', 'onload', 'onunload', 'onfocus', 'onblur', 'onchange', 'onsubmit', 'onreset', 'onselect', 'onkeypress', 'onkeydown', 'onkeyup']);
        $config->set('HTML.SafeScripting', []);
        $config->set('URI.SafeIframeRegexp', '%^%'); // Désactive les iframes
        
        // Configuration URI pour bloquer les protocoles dangereux
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true, 'ftp' => true]);
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
     * Configure le convertisseur Markdown
     */
    protected function configureMarkdownConverter(): void
    {
        // Créer un environnement CommonMark
        $environment = new Environment([
            'allow_unsafe_links' => false,
            'max_nesting_level' => 10,
            'html_input' => 'strip',
            'allow_inline_style' => false,
        ]);
        
        // Ajouter les extensions
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new TableExtension());
        
        $this->converter = new CommonMarkConverter([], $environment);
    }

    /**
     * Désinfecte et convertit le markdown en HTML sécurisé
     * 
     * @param string $markdown
     * @return HtmlString
     */
    public function sanitizeAndRender(string $markdown): HtmlString
    {
        if (empty(trim($markdown))) {
            return new HtmlString('');
        }
        
        // Désinfecter d'abord le markdown
        $cleanMarkdown = $this->sanitizeMarkdown($markdown);
        
        // Convertir en HTML en utilisant CommonMark
        $html = $this->converter->convert($cleanMarkdown);
        
        // Désinfecter le HTML résultant avec HTML Purifier
        $safeHtml = $this->purifier->purify($html);
        
        return new HtmlString($safeHtml);
    }

    /**
     * Désinfecte le contenu markdown avant conversion
     * 
     * @param string $markdown
     * @return string
     */
    protected function sanitizeMarkdown(string $markdown): string
    {
        // Supprimer les balises HTML mais garder le contenu texte
        $markdown = preg_replace('/<\w+\b[^>]*>(.*?)<\/\w+>/is', '$1', $markdown);
        $markdown = preg_replace('/<\w+\b[^>]*\/>/is', '', $markdown);
        
        // Supprimer les attributs dangereux dans le markdown restant
        $markdown = preg_replace('/\[(.*?)\]\((javascript|vbscript|data):[^)]*\)/is', '[$1](#)', $markdown);
        
        // Supprimer les event handlers
        $markdown = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/is', '', $markdown);
        
        // Nettoyer les lignes vides et les espaces
        $markdown = trim($markdown);
        
        // Ajouter un saut de ligne au début pour forcer le mode markdown
        if ($markdown !== '') {
            $markdown = "\n" . $markdown;
        }
        
        // Remplacer les sauts de ligne simples par des doubles sauts pour CommonMark
        $markdown = preg_replace('/\n([^\n])/', "\n\n$1", $markdown);
        
        return $markdown;
    }

    /**
     * Désinfecte directement du HTML
     * 
     * @param string $html
     * @return string
     */
    public function sanitizeHtml(string $html): string
    {
        return $this->purifier->purify($html);
    }
}