<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Ingredient;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\SeoMeta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CmsContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories
        $cat1 = ProductCategory::firstOrCreate(['slug' => 'organic-bar-soaps'], [
            'name' => 'Organic Bar Soaps',
            'description' => 'Cold-processed artisanal soap bars packed with organic botanical oils.',
            'image' => 'assets/images/beauty_soap.jpg',
            'icon' => 'fa-soap',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        $cat1->update(['image' => 'assets/images/beauty_soap.jpg']);

        $cat2 = ProductCategory::firstOrCreate(['slug' => 'exfoliating-body-scrubs'], [
            'name' => 'Exfoliating Body Scrubs',
            'description' => 'Gentle seed and herbal scrubs to reveal soft, radiant skin.',
            'image' => 'assets/images/herbal_soap.jpg',
            'icon' => 'fa-sparkles',
            'sort_order' => 2,
            'is_active' => true,
        ]);
        $cat2->update(['image' => 'assets/images/herbal_soap.jpg']);

        $cat3 = ProductCategory::firstOrCreate(['slug' => 'facial-cleansing-bars'], [
            'name' => 'Facial Cleansing Bars',
            'description' => 'Mild pH-balanced botanical bars tailored for delicate facial skin.',
            'image' => 'assets/images/moisturizing_soap.jpg',
            'icon' => 'fa-spa',
            'sort_order' => 3,
            'is_active' => true,
        ]);
        $cat3->update(['image' => 'assets/images/moisturizing_soap.jpg']);

        // 2. Ingredients
        $ing1 = Ingredient::firstOrCreate(['slug' => 'cold-pressed-virgin-olive-oil'], [
            'name' => 'Cold-Pressed Virgin Olive Oil',
            'image' => 'assets/images/beauty_soap.jpg',
            'short_description' => 'Rich in polyphenols and vitamin E to nourish skin lipid barriers deeply.',
            'full_description' => 'Our organic virgin olive oil is cold-pressed from Mediterranean groves, delivering dense hydration without clogging pores.',
            'benefits' => 'Deep moisture, Antioxidant shield, Smooth texture',
            'is_featured' => true,
            'status' => true,
            'sort_order' => 1,
        ]);
        $ing1->update(['image' => 'assets/images/beauty_soap.jpg']);

        $ing2 = Ingredient::firstOrCreate(['slug' => 'raw-unrefined-shea-butter'], [
            'name' => 'Raw Unrefined Shea Butter',
            'image' => 'assets/images/ing_shea.jpg',
            'short_description' => 'Ethically harvested African shea butter for velvety soft skin protection.',
            'full_description' => 'Fair-trade wild shea butter provides concentrated fatty acids and essential vitamins to restore skin elasticity.',
            'benefits' => 'Restores moisture, Soothes redness, Calms dry patches',
            'is_featured' => true,
            'status' => true,
            'sort_order' => 2,
        ]);

        $ing3 = Ingredient::firstOrCreate(['slug' => 'lavender-tea-tree-oil'], [
            'name' => 'Lavender & Tea Tree Oil',
            'image' => 'assets/images/ing_lavender.jpg',
            'short_description' => 'Calming French lavender combined with clarifying Australian tea tree.',
            'full_description' => 'Pure therapeutic grade essential oils provide natural antimicrobial power alongside a soothing floral aroma.',
            'benefits' => 'Clarifies pores, Calms senses, Natural antibacterial',
            'is_featured' => true,
            'status' => true,
            'sort_order' => 3,
        ]);

        // 3. Products
        $p1 = Product::firstOrCreate(['slug' => 'golden-honey-oat-hydrating-bar'], [
            'category_id' => $cat1->id,
            'name' => 'Golden Honey & Oat Hydrating Bar',
            'sku' => 'AURA-HONEY-01',
            'short_description' => 'Soothing raw wild honey and ground colloidal oats to calm and hydrate dry skin.',
            'description' => 'Formulated for dry and sensitive skin, this creamy bar combines raw wildflower honey with ground organic oats. Gently removes impurities while providing deep humectant moisture.',
            'product_image' => 'assets/images/prod_honey.jpg',
            'gallery' => ['assets/images/prod_honey.jpg', 'assets/images/about_artisan.jpg'],
            'benefits' => 'Soothes inflammation, Provides natural humectant hydration, Mild natural fragrance.',
            'usage_instructions' => 'Lather with warm water over moist skin. Massage gently and rinse thoroughly.',
            'weight' => '125g / 4.4 oz',
            'packaging_info' => '100% Biodegradable Recycled Paper Wrapper',
            'tags' => 'honey, oats, dry skin, gentle',
            'is_featured' => true,
            'status' => 'published',
            'sort_order' => 1,
        ]);
        $p1->ingredients()->syncWithoutDetaching([$ing1->id, $ing2->id]);

        $p2 = Product::firstOrCreate(['slug' => 'pure-lavender-shea-detox-bar'], [
            'category_id' => $cat1->id,
            'name' => 'Pure Lavender & Shea Detox Bar',
            'sku' => 'AURA-LAV-02',
            'short_description' => 'French lavender essential oil combined with French pink clay and raw shea butter.',
            'description' => 'Unwind after a long day with this calming aromatherapy soap. French pink clay draws out micro-pollutants while shea butter restores skin smoothness.',
            'product_image' => 'assets/images/prod_lavender.jpg',
            'gallery' => ['assets/images/prod_lavender.jpg'],
            'benefits' => 'Relieves daily stress, Purifies pores, Rich velvety lather.',
            'usage_instructions' => 'Use daily during bath or shower. Ideal for evening relaxation.',
            'weight' => '130g / 4.5 oz',
            'packaging_info' => 'Eco-Friendly FSC Certified Box',
            'tags' => 'lavender, detox, pink clay, shea',
            'is_featured' => true,
            'status' => 'published',
            'sort_order' => 2,
        ]);
        $p2->ingredients()->syncWithoutDetaching([$ing2->id, $ing3->id]);

        $p3 = Product::firstOrCreate(['slug' => 'tea-tree-activated-charcoal-bar'], [
            'category_id' => $cat3->id,
            'name' => 'Tea Tree & Activated Charcoal Bar',
            'sku' => 'AURA-CHAR-03',
            'short_description' => 'Deep pore cleansing bar infused with steam-activated coconut charcoal.',
            'description' => 'Target excess oil and blemish-prone skin naturally. Activated coconut charcoal acts like a magnet for impurities while tea tree essential oil keeps skin clear and fresh.',
            'product_image' => 'assets/images/prod_charcoal.jpg',
            'gallery' => ['assets/images/prod_charcoal.jpg'],
            'benefits' => 'Balances oily skin, Prevents breakouts, Non-drying formula.',
            'usage_instructions' => 'Lather on wet face or body twice daily. Avoid eye contact.',
            'weight' => '120g / 4.2 oz',
            'packaging_info' => 'Zero-waste Paper Wrap',
            'tags' => 'charcoal, tea tree, oily skin, acne care',
            'is_featured' => true,
            'status' => 'published',
            'sort_order' => 3,
        ]);
        $p3->ingredients()->syncWithoutDetaching([$ing3->id]);

        // 4. Process Steps
        ProcessStep::firstOrCreate(['step_number' => 1], ['title' => 'Ethical Sourcing', 'description' => 'We source certified organic botanical oils and fair-trade plant butter directly from sustainable farms.', 'sort_order' => 1]);
        ProcessStep::firstOrCreate(['step_number' => 2], ['title' => 'Cold-Process Blending', 'description' => 'Ingredients are blended at low temperatures to preserve therapeutic vitamins, enzymes, and antioxidants.', 'sort_order' => 2]);
        ProcessStep::firstOrCreate(['step_number' => 3], ['title' => '6-Week Curing', 'description' => 'Every artisanal batch is hand-cut and naturally cured for 6 full weeks to create a long-lasting, ultra-mild soap.', 'sort_order' => 3]);
        ProcessStep::firstOrCreate(['step_number' => 4], ['title' => 'Eco Packaging', 'description' => 'Inspected, quality-checked, and wrapped in 100% plastic-free compostable materials.', 'sort_order' => 4]);

        // 5. Testimonials
        Testimonial::firstOrCreate(['customer_name' => 'Sophia Martinez'], [
            'country' => 'United States',
            'designation' => 'Verified Buyer',
            'testimonial' => 'Aura Soaps transformed my dry eczema-prone skin within two weeks. The Golden Honey bar leaves my skin soft without synthetic perfume.',
            'rating' => 5,
            'is_featured' => true,
            'status' => true,
            'sort_order' => 1,
        ]);
        Testimonial::firstOrCreate(['customer_name' => 'Elena Rostova'], [
            'country' => 'Germany',
            'designation' => 'Eco Skincare Enthusiast',
            'testimonial' => 'The aroma of the Lavender Detox bar is divine! You can immediately feel the quality of cold-pressed oils compared to commercial soap bars.',
            'rating' => 5,
            'is_featured' => true,
            'status' => true,
            'sort_order' => 2,
        ]);

        // 6. Blog Category & Posts
        $bCat = BlogCategory::firstOrCreate(['slug' => 'botanical-skincare'], ['name' => 'Botanical Skincare', 'description' => 'Tips and guides on organic skincare and eco bathing rituals.']);
        
        $adminUser = User::first();

        BlogPost::firstOrCreate(['slug' => 'why-cold-processed-soap-is-superior-for-skin-barrier'], [
            'category_id' => $bCat->id,
            'author_id' => $adminUser ? $adminUser->id : null,
            'title' => 'Why Cold-Processed Soap is Superior for Your Skin Barrier',
            'featured_image' => 'assets/images/blog_1.jpg',
            'excerpt' => 'Discover how natural glycerin and unheated botanical oils protect your skin moisture barrier compared to industrial synthetic detergents.',
            'content' => '<p>Industrial soap bars frequently extract natural glycerin to sell separately in moisturizing lotions. At Aura Soaps, our artisanal cold-process method retains 100% of organic glycerin...</p>',
            'tags' => 'cold process, skin barrier, natural soap',
            'publish_date' => now(),
            'is_featured' => true,
            'status' => 'published',
        ]);

        // 7. FAQs
        Faq::firstOrCreate(['question' => 'Are Aura Soaps 100% natural and cruelty-free?'], ['category' => 'Ingredients', 'answer' => 'Yes! All Aura Soaps are handcrafted with 100% organic plant oils, essential oils, and botanicals. We never test on animals or use synthetic sulfates or parabens.', 'sort_order' => 1]);
        Faq::firstOrCreate(['question' => 'How long does one Aura soap bar last?'], ['category' => 'Usage', 'answer' => 'Our bars last 3 to 4 weeks with daily use when kept on a draining soap dish to stay dry between uses.', 'sort_order' => 2]);

        // 8. Page-wise SEO Metas
        $defaultMetas = [
            [
                'page_route' => 'home',
                'title' => 'Aura Soaps | Natural Care • Pure Touch',
                'meta_description' => 'Handcrafted natural soaps, botanical skincare, and cold-processed organic bath products enriched with raw plant oils.',
                'focus_keyword' => 'natural soaps',
                'robots' => 'index, follow',
            ],
            [
                'page_route' => 'about-us',
                'title' => 'About Us | Artisanal Organic Bath Care • Aura Soaps',
                'meta_description' => 'Learn about our cold-process formulation, 6-week curing process, ethical ingredient sourcing, and plastic-free mission.',
                'focus_keyword' => 'artisanal soap maker',
                'robots' => 'index, follow',
            ],
            [
                'page_route' => 'products',
                'title' => 'Products Catalog | Organic Bar Soaps & Body Scrubs',
                'meta_description' => 'Explore our complete range of handcrafted cold-processed soap bars, body scrubs, and facial cleansing bars.',
                'focus_keyword' => 'organic bar soaps',
                'robots' => 'index, follow',
            ],
            [
                'page_route' => 'ingredients',
                'title' => 'Botanical Ingredients | Cold-Pressed Oils & Plant Butters',
                'meta_description' => 'Discover the therapeutic benefits of our organic extra virgin olive oil, raw unrefined shea butter, and essential oils.',
                'focus_keyword' => 'organic soap ingredients',
                'robots' => 'index, follow',
            ],
            [
                'page_route' => 'blog',
                'title' => 'Botanical Journal & Skincare Articles | Aura Soaps',
                'meta_description' => 'Read expert guides, eco bathing rituals, and skincare advice to maintain a healthy skin lipid barrier naturally.',
                'focus_keyword' => 'skincare tips',
                'robots' => 'index, follow',
            ],
            [
                'page_route' => 'become-a-distributor',
                'title' => 'Become a Distributor | Global Wholesale Partnership',
                'meta_description' => 'Join Aura Soaps global distributor network. Expand your boutique or store with premium artisanal organic soaps.',
                'focus_keyword' => 'soap distributor',
                'robots' => 'index, follow',
            ],
            [
                'page_route' => 'faq',
                'title' => 'Frequently Asked Questions | Aura Soaps',
                'meta_description' => 'Find answers to common questions regarding ingredients, soap bar longevity, eco packaging, and shipping options.',
                'focus_keyword' => 'soap faq',
                'robots' => 'index, follow',
            ],
            [
                'page_route' => 'contact',
                'title' => 'Contact Us | Customer Support & Wholesale Enquiries',
                'meta_description' => 'Get in touch with the Aura Soaps support team for product guidance, order inquiries, and partnership requests.',
                'focus_keyword' => 'contact aura soaps',
                'robots' => 'index, follow',
            ],
            [
                'page_route' => 'agent-locator',
                'title' => 'Find a Principal Agent | Aura Soaps Regional Network',
                'meta_description' => 'Locate an authorized Aura Soaps Principal Agent in your province, district, or town in Rwanda, DRC, Uganda, and Tanzania.',
                'focus_keyword' => 'agent locator',
                'robots' => 'index, follow',
            ],
        ];

        foreach ($defaultMetas as $metaData) {
            SeoMeta::firstOrCreate(['page_route' => $metaData['page_route']], $metaData);
        }

        // 9. Principal Agents
        $agentsData = [
            // Rwanda
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Kigali', 'province_state' => 'Kigali', 'agent_count' => 20, 'sort_order' => 1],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Nyanza (Nyanza)', 'province_state' => 'Southern', 'agent_count' => 2, 'sort_order' => 2],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Gisagara (Ndora)', 'province_state' => 'Southern', 'agent_count' => 2, 'sort_order' => 3],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Nyaruguru (Kibeho)', 'province_state' => 'Southern', 'agent_count' => 2, 'sort_order' => 4],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Huye (Butare City)', 'province_state' => 'Southern', 'agent_count' => 4, 'sort_order' => 5],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Nyamagabe (Gasaka Town)', 'province_state' => 'Southern', 'agent_count' => 2, 'sort_order' => 6],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Ruhango (Ruhango City)', 'province_state' => 'Southern', 'agent_count' => 4, 'sort_order' => 7],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Muhanga (Gitarama/Muhanga City)', 'province_state' => 'Southern', 'agent_count' => 4, 'sort_order' => 8],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Kamonyi (Kamonyi City)', 'province_state' => 'Southern', 'agent_count' => 4, 'sort_order' => 9],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Karongi (Kibuye/Rubengera)', 'province_state' => 'Western', 'agent_count' => 3, 'sort_order' => 10],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Rutsiro (Gihango Town)', 'province_state' => 'Western', 'agent_count' => 2, 'sort_order' => 11],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Rubavu (Gisenyi)', 'province_state' => 'Western', 'agent_count' => 4, 'sort_order' => 12],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Nyabihu (Mukamira Town)', 'province_state' => 'Western', 'agent_count' => 3, 'sort_order' => 13],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Ngororero (Ngororero Town)', 'province_state' => 'Western', 'agent_count' => 2, 'sort_order' => 14],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Rusizi (Kamembe)', 'province_state' => 'Western', 'agent_count' => 4, 'sort_order' => 15],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Nyamasheke (Kagano/Cyangugu)', 'province_state' => 'Western', 'agent_count' => 4, 'sort_order' => 16],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Rulindo (Tare Town)', 'province_state' => 'Northern', 'agent_count' => 3, 'sort_order' => 17],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Gakenke (Gakenke Town)', 'province_state' => 'Northern', 'agent_count' => 2, 'sort_order' => 18],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Musanze (Ruhengeri City)', 'province_state' => 'Northern', 'agent_count' => 4, 'sort_order' => 19],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Burera (Cyeru Town)', 'province_state' => 'Northern', 'agent_count' => 3, 'sort_order' => 20],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Gicumbi (Byumba)', 'province_state' => 'Northern', 'agent_count' => 2, 'sort_order' => 21],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Rwamagana (Rwamagana City)', 'province_state' => 'Eastern', 'agent_count' => 4, 'sort_order' => 22],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Nyagatare (Nyagatare City)', 'province_state' => 'Eastern', 'agent_count' => 4, 'sort_order' => 23],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Gatsibo (Kabarore Town)', 'province_state' => 'Eastern', 'agent_count' => 2, 'sort_order' => 24],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Kayonza (Kayonza Town)', 'province_state' => 'Eastern', 'agent_count' => 2, 'sort_order' => 25],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Kirehe (Rusumo)', 'province_state' => 'Eastern', 'agent_count' => 2, 'sort_order' => 26],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Ngoma (Kibungo)', 'province_state' => 'Eastern', 'agent_count' => 2, 'sort_order' => 27],
            ['market' => 'rwanda', 'country' => 'rwanda', 'city_town' => 'Bugesera (Nyamata)', 'province_state' => 'Eastern', 'agent_count' => 4, 'sort_order' => 28],
            // DRC
            ['market' => 'regional', 'country' => 'drc', 'city_town' => 'Goma', 'province_state' => 'North Kivu', 'agent_count' => 4, 'sort_order' => 29],
            ['market' => 'regional', 'country' => 'drc', 'city_town' => 'Bukavu', 'province_state' => 'South Kivu', 'agent_count' => 4, 'sort_order' => 30],
            ['market' => 'regional', 'country' => 'drc', 'city_town' => 'Uvira', 'province_state' => 'South Kivu', 'agent_count' => 4, 'sort_order' => 31],
            ['market' => 'regional', 'country' => 'drc', 'city_town' => 'Bunia', 'province_state' => 'Ituri Province', 'agent_count' => 2, 'sort_order' => 32],
            // Uganda
            ['market' => 'regional', 'country' => 'uganda', 'city_town' => 'Kabale', 'province_state' => 'Kigezi Sub-region', 'agent_count' => 2, 'sort_order' => 33],
            ['market' => 'regional', 'country' => 'uganda', 'city_town' => 'Kisoro', 'province_state' => 'Kigezi Sub-region', 'agent_count' => 2, 'sort_order' => 34],
            ['market' => 'regional', 'country' => 'uganda', 'city_town' => 'Mbarara', 'province_state' => 'Western Region', 'agent_count' => 3, 'sort_order' => 35],
            ['market' => 'regional', 'country' => 'uganda', 'city_town' => 'Rukungiri', 'province_state' => 'Western Region', 'agent_count' => 2, 'sort_order' => 36],
            ['market' => 'regional', 'country' => 'uganda', 'city_town' => 'Ibanda', 'province_state' => 'Western Region', 'agent_count' => 2, 'sort_order' => 37],
            ['market' => 'regional', 'country' => 'uganda', 'city_town' => 'Bushenyi', 'province_state' => 'Western Region', 'agent_count' => 2, 'sort_order' => 38],
            ['market' => 'regional', 'country' => 'uganda', 'city_town' => 'Isingiro', 'province_state' => 'Western Region', 'agent_count' => 2, 'sort_order' => 39],
            ['market' => 'regional', 'country' => 'uganda', 'city_town' => 'Kanungu', 'province_state' => 'Western Region', 'agent_count' => 2, 'sort_order' => 40],
            ['market' => 'regional', 'country' => 'uganda', 'city_town' => 'Kiruhura', 'province_state' => 'Western Region', 'agent_count' => 2, 'sort_order' => 41],
            ['market' => 'regional', 'country' => 'uganda', 'city_town' => 'Ntungamo', 'province_state' => 'Western Region', 'agent_count' => 2, 'sort_order' => 42],
            ['market' => 'regional', 'country' => 'uganda', 'city_town' => 'Shema – Kibingo', 'province_state' => 'Western Region', 'agent_count' => 2, 'sort_order' => 43],
            // Tanzania
            ['market' => 'regional', 'country' => 'tanzania', 'city_town' => 'Rusumo', 'province_state' => 'Kagera Region', 'agent_count' => 1, 'sort_order' => 44],
        ];

        foreach ($agentsData as $agent) {
            \App\Models\Agent::firstOrCreate([
                'country' => $agent['country'],
                'city_town' => $agent['city_town']
            ], $agent);
        }
    }
}
