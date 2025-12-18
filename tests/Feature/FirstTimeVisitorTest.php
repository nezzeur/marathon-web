<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FirstTimeVisitorTest extends TestCase
{
    /**
     * Test redirection vers la page first pour les nouveaux visiteurs
     *
     * @return void
     */
    public function test_new_visitor_redirected_to_first_page()
    {
        // Simuler un nouveau visiteur (sans cookie)
        $response = $this->get('/');
        
        // Vérifier que la redirection vers la page first se produit
        $response->assertRedirect(route('first.page'));
    }

    /**
     * Test que la page first affiche correctement la vue
     *
     * @return void
     */
    public function test_first_page_displays_correctly()
    {
        $response = $this->get('/first');
        
        $response->assertStatus(200);
        $response->assertViewIs('first');
    }

    /**
     * Test que les visiteurs existants ne sont pas redirigés vers first
     *
     * @return void
     */
    public function test_existing_visitor_not_redirected_to_first()
    {
        // Simuler un visiteur existant avec le cookie
        $response = $this->withCookie('okrina_visited', 'true')->get('/');
        
        // Vérifier que la page d'accueil est affichée normalement
        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    /**
     * Test que les visiteurs existants sont redirigés depuis first vers home
     *
     * @return void
     */
    public function test_existing_visitor_redirected_from_first_to_home()
    {
        // Simuler un visiteur existant qui accède à /first
        $response = $this->withCookie('okrina_visited', 'true')->get('/first');
        
        // Vérifier la redirection vers la page d'accueil
        $response->assertRedirect(route('home'));
    }

    /**
     * Test que les routes sensibles ne sont pas redirigées
     *
     * @return void
     */
    public function test_sensitive_routes_not_redirected()
    {
        // Tester que les routes d'authentification ne sont pas redirigées
        $loginResponse = $this->get('/login');
        $loginResponse->assertStatus(200);
        
        $registerResponse = $this->get('/register');
        $registerResponse->assertStatus(200);
    }
}