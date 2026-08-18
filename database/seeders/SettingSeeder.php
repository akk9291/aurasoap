<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General & Branding
            ['key' => 'site_name', 'value' => 'Aura Soaps', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Natural Care • Pure Touch', 'group' => 'general'],
            ['key' => 'site_logo', 'value' => 'assets/images/logo.png', 'group' => 'general'],
            ['key' => 'site_favicon', 'value' => 'assets/images/logo.png', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Aura Soaps offers handcrafted natural soaps and eco-friendly skincare made with skin-loving organic botanicals, shea butter, and essential oils.', 'group' => 'general'],
            
            // Contact & Business Information
            ['key' => 'contact_email', 'value' => 'hello@aurasoaps.com', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+1 (800) 555-2872', 'group' => 'contact'],
            ['key' => 'contact_whatsapp', 'value' => '+1 (800) 555-2872', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => '108 Pure Botanical Way, Eco Valley, CA 90210, United States', 'group' => 'contact'],
            ['key' => 'working_hours', 'value' => 'Mon - Sat: 9:00 AM - 6:00 PM EST', 'group' => 'contact'],
            ['key' => 'distributor_email', 'value' => 'agents@aurasoaps.com', 'group' => 'contact'],
            ['key' => 'support_email', 'value' => 'support@aurasoaps.com', 'group' => 'contact'],

            // Social Media
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/aurasoaps', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/aurasoaps', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/aurasoaps', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@aurasoaps', 'group' => 'social'],
            ['key' => 'social_tiktok', 'value' => 'https://tiktok.com/@aurasoaps', 'group' => 'social'],
        ];

        foreach ($settings as $s) {
            Setting::set($s['key'], $s['value'], $s['group']);
        }
    }
}
