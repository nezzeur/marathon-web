<?php

namespace Tests\Feature;

use App\Models\Accessibilite;
use App\Models\Article;
use App\Models\Conclusion;
use App\Models\Rythme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleSearchTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $accessibilite;
    protected $conclusion;
    protected $rythme;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer les données de test nécessaires
        $this->user = User::factory()->create();
        $this->accessibilite = Accessibilite::factory()->create(['nom' => 'Facile']);
        $this->conclusion = Conclusion::factory()->create(['nom' => 'Positive']);
        $this->rythme = Rythme::factory()->create(['nom' => 'Rapide']);
    }

    /**
     * Test de recherche par titre
     */
    public function test_search_by_title()
    {
        // Créer un article avec un titre spécifique
        $article = Article::factory()->create([
            'titre' => 'Test Article Title',
            'user_id' => $this->user->id,
            'accessibilite_id' => $this->accessibilite->id,
            'conclusion_id' => $this->conclusion->id,
            'rythme_id' => $this->rythme->id,
        ]);

        // Effectuer la recherche
        $response = $this->get('/articles/search?title=Test');

        // Vérifier que la recherche fonctionne
        $response->assertStatus(200);
        $response->assertViewIs('articles.search_results');
        $response->assertSee('Test Article Title');
    }

    /**
     * Test de recherche par accessibilité
     */
    public function test_search_by_accessibilite()
    {
        $article = Article::factory()->create([
            'titre' => 'Accessibility Test',
            'user_id' => $this->user->id,
            'accessibilite_id' => $this->accessibilite->id,
            'conclusion_id' => $this->conclusion->id,
            'rythme_id' => $this->rythme->id,
        ]);

        $response = $this->get('/articles/search?accessibilite=' . $this->accessibilite->id);

        $response->assertStatus(200);
        $response->assertViewIs('articles.search_results');
        $response->assertSee('Accessibility Test');
    }

    /**
     * Test de recherche par conclusion
     */
    public function test_search_by_conclusion()
    {
        $article = Article::factory()->create([
            'titre' => 'Conclusion Test',
            'user_id' => $this->user->id,
            'accessibilite_id' => $this->accessibilite->id,
            'conclusion_id' => $this->conclusion->id,
            'rythme_id' => $this->rythme->id,
        ]);

        $response = $this->get('/articles/search?conclusion=' . $this->conclusion->id);

        $response->assertStatus(200);
        $response->assertViewIs('articles.search_results');
        $response->assertSee('Conclusion Test');
    }

    /**
     * Test de recherche par rythme
     */
    public function test_search_by_rythme()
    {
        $article = Article::factory()->create([
            'titre' => 'Rythme Test',
            'user_id' => $this->user->id,
            'accessibilite_id' => $this->accessibilite->id,
            'conclusion_id' => $this->conclusion->id,
            'rythme_id' => $this->rythme->id,
        ]);

        $response = $this->get('/articles/search?rythme=' . $this->rythme->id);

        $response->assertStatus(200);
        $response->assertViewIs('articles.search_results');
        $response->assertSee('Rythme Test');
    }

    /**
     * Test de recherche combinée
     */
    public function test_combined_search()
    {
        $article = Article::factory()->create([
            'titre' => 'Combined Search Test',
            'user_id' => $this->user->id,
            'accessibilite_id' => $this->accessibilite->id,
            'conclusion_id' => $this->conclusion->id,
            'rythme_id' => $this->rythme->id,
        ]);

        $response = $this->get('/articles/search?' . http_build_query([
            'title' => 'Combined',
            'accessibilite' => $this->accessibilite->id,
            'conclusion' => $this->conclusion->id,
            'rythme' => $this->rythme->id,
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('articles.search_results');
        $response->assertSee('Combined Search Test');
    }

    /**
     * Test de recherche sans résultats
     */
    public function test_search_with_no_results()
    {
        $response = $this->get('/articles/search?title=NonExistentArticleTitle12345');

        $response->assertStatus(200);
        $response->assertViewIs('articles.search_results');
        $response->assertSee('Aucun article trouvé');
    }

    /**
     * Test de recherche sans paramètres
     */
    public function test_search_without_parameters()
    {
        // Créer quelques articles
        Article::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'accessibilite_id' => $this->accessibilite->id,
            'conclusion_id' => $this->conclusion->id,
            'rythme_id' => $this->rythme->id,
        ]);

        $response = $this->get('/articles/search');

        $response->assertStatus(200);
        $response->assertViewIs('articles.search_results');
        // Devrait afficher tous les articles
        $response->assertViewHas('articles');
    }

    /**
     * Test que la route de recherche existe
     */
    public function test_search_route_exists()
    {
        $response = $this->get('/articles/search');
        $response->assertStatus(200);
    }
}