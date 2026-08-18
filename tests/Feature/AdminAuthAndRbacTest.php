<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthAndRbacTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles & permissions
        $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);
    }

    protected function createAdminUser($roleSlug)
    {
        $user = User::factory()->create([
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        $role = Role::where('slug', $roleSlug)->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }

        return $user;
    }

    public function test_admin_can_view_login_page()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('Admin Portal');
    }

    public function test_admin_can_login_with_correct_credentials()
    {
        $user = $this->createAdminUser('super-admin');

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_cannot_login_with_incorrect_credentials()
    {
        $user = $this->createAdminUser('super-admin');

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_forgot_password_page_can_be_rendered()
    {
        $response = $this->get('/admin/forgot-password');
        $response->assertStatus(200);
        $response->assertSee('Reset Your Password');
    }

    public function test_password_reset_link_can_be_requested()
    {
        $user = $this->createAdminUser('super-admin');

        $response = $this->post('/admin/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertSessionHas('status');
    }

    public function test_super_admin_can_access_all_admin_routes()
    {
        $superAdmin = $this->createAdminUser('super-admin');

        $this->actingAs($superAdmin)->get('/admin')->assertStatus(200);
        $this->actingAs($superAdmin)->get('/admin/products')->assertStatus(200);
        $this->actingAs($superAdmin)->get('/admin/categories')->assertStatus(200);
        $this->actingAs($superAdmin)->get('/admin/ingredients')->assertStatus(200);
        $this->actingAs($superAdmin)->get('/admin/blog')->assertStatus(200);
        $this->actingAs($superAdmin)->get('/admin/enquiries')->assertStatus(200);
        $this->actingAs($superAdmin)->get('/admin/seo')->assertStatus(200);
        $this->actingAs($superAdmin)->get('/admin/users')->assertStatus(200);
        $this->actingAs($superAdmin)->get('/admin/settings')->assertStatus(200);
    }

    public function test_content_manager_can_access_products_and_blogs()
    {
        $contentManager = $this->createAdminUser('content-manager');

        $this->actingAs($contentManager)->get('/admin/products')->assertStatus(200);
        $this->actingAs($contentManager)->get('/admin/categories')->assertStatus(200);
        $this->actingAs($contentManager)->get('/admin/blog')->assertStatus(200);
    }

    public function test_content_manager_cannot_access_users_or_settings_direct_url_returns_403()
    {
        $contentManager = $this->createAdminUser('content-manager');

        $this->actingAs($contentManager)->get('/admin/users')->assertStatus(403);
        $this->actingAs($contentManager)->get('/admin/settings')->assertStatus(403);
        $this->actingAs($contentManager)->get('/admin/seo')->assertStatus(403);
        $this->actingAs($contentManager)->get('/admin/enquiries')->assertStatus(403);
    }

    public function test_seo_manager_can_access_seo_and_cannot_access_users()
    {
        $seoManager = $this->createAdminUser('seo-manager');

        $this->actingAs($seoManager)->get('/admin/seo')->assertStatus(200);
        $this->actingAs($seoManager)->get('/admin/redirects')->assertStatus(200);

        $this->actingAs($seoManager)->get('/admin/users')->assertStatus(403);
        $this->actingAs($seoManager)->get('/admin/products')->assertStatus(403);
        $this->actingAs($seoManager)->get('/admin/enquiries')->assertStatus(403);
    }

    public function test_enquiry_manager_can_access_enquiries_and_cannot_access_products()
    {
        $enquiryManager = $this->createAdminUser('enquiry-manager');

        $this->actingAs($enquiryManager)->get('/admin/enquiries')->assertStatus(200);
        $this->actingAs($enquiryManager)->get('/admin/distributors')->assertStatus(200);

        $this->actingAs($enquiryManager)->get('/admin/products')->assertStatus(403);
        $this->actingAs($enquiryManager)->get('/admin/users')->assertStatus(403);
        $this->actingAs($enquiryManager)->get('/admin/seo')->assertStatus(403);
    }

    public function test_cannot_delete_last_super_admin()
    {
        $superAdmin = $this->createAdminUser('super-admin');

        // Acting as super admin trying to delete the single super admin account
        $response = $this->actingAs($superAdmin)->delete('/admin/users/' . $superAdmin->id);

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $superAdmin->id]);
    }
}
