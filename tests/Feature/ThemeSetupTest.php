<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ThemeSetupTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_renders_dual_theme_and_zero_fouc_setup(): void
    {
        $response = $this->get('/');

        $this->assertThemeMarkup($response);
    }

    public function test_auth_pages_render_dual_theme_and_zero_fouc_setup(): void
    {
        $this->assertThemeMarkup($this->get('/login'));
        $this->assertThemeMarkup($this->get('/register'));
    }

    public function test_dashboard_renders_dual_theme_and_zero_fouc_setup(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $this->assertThemeMarkup($response);
    }

    private function assertThemeMarkup(TestResponse $response): void
    {
        $response->assertOk()
            ->assertSee("tallstackui_darkTheme({ default: 'light' })", false)
            ->assertSee('x-bind:class="{ \'dark\': darkTheme }"', false)
            ->assertSee("localStorage.getItem('dark-theme')", false)
            ->assertSee('livewire:navigated', false)
            ->assertSee('[x-cloak] { display: none !important; }', false)
            ->assertSee('role="switch"', false)
            ->assertSee("mode = darkTheme ? 'light' : 'dark'", false);
    }
}
