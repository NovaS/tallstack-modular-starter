<?php

namespace Tests\Feature;

use App\Models\User;
use App\Modules\Auth\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_render_login_and_registration_and_dashboard_requires_authentication(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('/tallstackui/script/', false)
            ->assertSee('livewire', false);

        $this->get('/register')
            ->assertOk()
            ->assertSee('/tallstackui/script/', false);

        $this->get('/dashboard')->assertRedirect(route('login'));
    }

    public function test_authenticated_dashboard_renders_tall_stack_layout_and_user_details(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'jane@example.com',
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('/tallstackui/script/', false)
            ->assertSee('livewire', false)
            ->assertSeeText('Welcome, Jane Doe')
            ->assertSeeText('jane@example.com');
    }

    public function test_registration_creates_user_with_username_and_email_and_authenticates_without_assigning_a_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'Test_User_01',
            'email' => 'Test@Example.com',
            'password' => 'StrongPassword123!',
            'password_confirmation' => 'StrongPassword123!',
        ]);

        $user = User::query()->where('email', 'test@example.com')->firstOrFail();

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->assertSame('Test User', $user->name);
        $this->assertSame('test_user_01', $user->username);
        $this->assertTrue(Hash::check('StrongPassword123!', $user->password));
        $this->assertSame(0, $user->roles()->count());
    }

    public function test_login_authenticates_using_email_when_configured_to_email(): void
    {
        config(['auth.login_id' => 'email']);

        $user = User::factory()->create([
            'username' => 'standarduser',
            'email' => 'standard@example.com',
            'password' => Hash::make('StrongPassword123!'),
        ]);

        $response = $this->post('/login', [
            'email' => 'STANDARD@example.com',
            'password' => 'StrongPassword123!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_authenticates_using_username_when_configured_to_username(): void
    {
        config(['auth.login_id' => 'username']);

        $this->get('/login')
            ->assertOk()
            ->assertSee('name="username"', false);

        $user = User::factory()->create([
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => Hash::make('StrongPassword123!'),
        ]);

        $response = $this->post('/login', [
            'username' => 'JohnDoe',
            'password' => 'StrongPassword123!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_schema_and_permission_morph_key_match_standard_primary_key(): void
    {
        $this->assertSame(
            ['id', 'name', 'username', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at'],
            Schema::getColumnListing('users')
        );
        $this->assertSame('model_id', config('permission.column_names.model_morph_key'));
        $this->assertTrue(Schema::hasColumn('model_has_roles', 'model_id'));
        $this->assertTrue(Schema::hasColumn('model_has_permissions', 'model_id'));
    }

    public function test_spatie_role_and_permission_middleware_authorize_the_user_model(): void
    {
        Route::middleware(['auth', 'role:admin'])->get('/_test/role', fn () => response('role granted'));
        Route::middleware(['auth', 'permission:reports.view'])->get('/_test/permission', fn () => response('permission granted'));

        $user = User::factory()->create();

        $this->actingAs($user)->get('/_test/role')->assertForbidden();
        $user->assignRole(Role::findOrCreate('admin', 'web'));
        $this->actingAs($user)->get('/_test/role')->assertOk()->assertSeeText('role granted');

        $user->givePermissionTo(Permission::findOrCreate('reports.view', 'web'));
        $this->actingAs($user)->get('/_test/permission')->assertOk()->assertSeeText('permission granted');

        $this->assertDatabaseHas('model_has_roles', [
            'model_id' => $user->id,
            'model_type' => User::class,
        ]);
    }

    public function test_modular_architecture_registers_module_views_livewire_namespaces_and_services(): void
    {
        $this->assertTrue(View::exists('auth::login'));
        $this->assertTrue(View::exists('auth::register'));
        $this->assertTrue(View::exists('dashboard::index'));

        $finder = app('livewire.finder');
        $this->assertNotNull($finder->getClassNamespace('auth'));
        $this->assertSame('App\\Modules\\Auth\\Livewire', $finder->getClassNamespace('auth')['classNamespace']);
        $this->assertNotNull($finder->getClassNamespace('dashboard'));
        $this->assertSame('App\\Modules\\Dashboard\\Livewire', $finder->getClassNamespace('dashboard')['classNamespace']);

        $authService = app(AuthService::class);
        $user = $authService->register([
            'name' => 'Modular User',
            'username' => 'modularuser',
            'email' => 'modular@example.com',
            'password' => 'StrongPassword123!',
        ]);

        $this->assertAuthenticatedAs($user);
    }
}
