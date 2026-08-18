<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Full control over the entire system.'],
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Manage website content, products, blogs, and enquiries.'],
            ['name' => 'Content Manager', 'slug' => 'content-manager', 'description' => 'Manage products, categories, ingredients, blogs, FAQs, and testimonials.'],
            ['name' => 'SEO Manager', 'slug' => 'seo-manager', 'description' => 'Manage SEO metadata, sitemaps, robots, redirects, and schema.'],
            ['name' => 'Enquiry Manager', 'slug' => 'enquiry-manager', 'description' => 'Manage contact enquiries, distributor applications, and subscribers.'],
        ];

        foreach ($roles as $r) {
            Role::firstOrCreate(['slug' => $r['slug']], $r);
        }

        $permissions = [
            ['name' => 'Manage Users', 'slug' => 'manage-users', 'group' => 'system'],
            ['name' => 'Manage Settings', 'slug' => 'manage-settings', 'group' => 'system'],
            ['name' => 'Manage Products', 'slug' => 'manage-products', 'group' => 'content'],
            ['name' => 'Manage Categories', 'slug' => 'manage-categories', 'group' => 'content'],
            ['name' => 'Manage Ingredients', 'slug' => 'manage-ingredients', 'group' => 'content'],
            ['name' => 'Manage Blog', 'slug' => 'manage-blog', 'group' => 'content'],
            ['name' => 'Manage FAQs', 'slug' => 'manage-faqs', 'group' => 'content'],
            ['name' => 'Manage Testimonials', 'slug' => 'manage-testimonials', 'group' => 'content'],
            ['name' => 'Manage SEO', 'slug' => 'manage-seo', 'group' => 'seo'],
            ['name' => 'Manage Enquiries', 'slug' => 'manage-enquiries', 'group' => 'enquiries'],
            ['name' => 'Manage Distributors', 'slug' => 'manage-distributors', 'group' => 'enquiries'],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['slug' => $p['slug']], $p);
        }

        // Attach permissions to roles
        $allPermissions = Permission::all();

        $superAdmin = Role::where('slug', 'super-admin')->first();
        if ($superAdmin) {
            $superAdmin->permissions()->sync($allPermissions->pluck('id'));
        }

        $admin = Role::where('slug', 'admin')->first();
        if ($admin) {
            $adminPerms = Permission::where('slug', '!=', 'manage-users')->pluck('id');
            $admin->permissions()->sync($adminPerms);
        }

        $contentManager = Role::where('slug', 'content-manager')->first();
        if ($contentManager) {
            $cmPerms = Permission::whereIn('slug', [
                'manage-products', 'manage-categories', 'manage-ingredients', 
                'manage-blog', 'manage-faqs', 'manage-testimonials'
            ])->pluck('id');
            $contentManager->permissions()->sync($cmPerms);
        }

        $seoManager = Role::where('slug', 'seo-manager')->first();
        if ($seoManager) {
            $seoPerms = Permission::whereIn('slug', ['manage-seo'])->pluck('id');
            $seoManager->permissions()->sync($seoPerms);
        }

        $enquiryManager = Role::where('slug', 'enquiry-manager')->first();
        if ($enquiryManager) {
            $enquiryPerms = Permission::whereIn('slug', ['manage-enquiries', 'manage-distributors'])->pluck('id');
            $enquiryManager->permissions()->sync($enquiryPerms);
        }
    }
}
