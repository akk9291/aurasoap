<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Addendum2Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Update Core Settings from Addendum 2
        $settings = [
            'site_name' => 'Aura Soaps',
            'site_tagline' => 'PURE NATURE.... PERFECT SKIN CARE....',
            'contact_phone' => '+250 795 602 083',
            'contact_whatsapp' => '+250 795 602 083',
            'contact_email' => 'sales1@aura-soaps.com',
            'sales_email_1' => 'sales1@aura-soaps.com',
            'sales_email_2' => 'sales2@aura-soaps.com',
            'sales_email_3' => 'sales3@aura-soaps.com',
            'contact_address' => 'Kigali Special Economic Zone / Nyarugenge Commercial District, Kigali, Rwanda',
            'site_mission' => 'A boutique & Design-Forward Company (The Premium Visual Brand) — Elevating ordinary, utility-driven bathroom and kitchen products into artistic home décor items.',
            'site_vision' => 'Becoming the Regional Hallmark for sustainable, luxurious, and accessible eco-friendly fast-moving consumer goods (FMCGs) related to skincare, hygiene, sanitation, and good health.',
            'company_slogan' => 'Quality – All – Round.',
        ];

        foreach ($settings as $k => $v) {
            Setting::updateOrCreate(['key' => $k], ['value' => $v, 'group' => 'general']);
        }

        // 2. Product Categories
        // Deactivate old legacy categories not in the official document
        ProductCategory::whereNotIn('slug', [
            'laundry-bar-soap',
            'toilet-bath-soap',
            'luxury-toilet-paper',
            'kitchen-table-paper-towel',
            'personal-care-rollon',
            'natural-beauty-soap'
        ])->update(['is_active' => false]);

        $categoriesData = [
            [
                'name' => 'Laundry Bar Soap',
                'slug' => 'laundry-bar-soap',
                'description' => 'High-performing cleaners packed with active enzymes and natural organic oils that effectively lift tough stains while protecting fabric color and skin.',
                'image' => 'storage/addendum_images/page_3_2.png',
                'icon' => 'fa-soap',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Toilet Bath Soap',
                'slug' => 'toilet-bath-soap',
                'description' => 'High Total Fatty Matter (TFM 70-76%) cleansing bar soaps retaining beneficial natural glycerine for deep moisture and delicate scents.',
                'image' => 'storage/addendum_images/page_4_4.png',
                'icon' => 'fa-bath',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Luxury Toilet Paper',
                'slug' => 'luxury-toilet-paper',
                'description' => '1 & 2-Ply thick, pillow-soft, cushiony, high-absorbency toilet paper made from pure virgin wood pulp fibers that dissolves easily in water.',
                'image' => 'storage/addendum_images/page_5_5.png',
                'icon' => 'fa-scroll',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Kitchen & Table Paper Towel',
                'slug' => 'kitchen-table-paper-towel',
                'description' => 'Soft, strong, high wet-strength embossed paper hand towels engineered for maximum plushness, fluid collection, and lint-free hygiene.',
                'image' => 'storage/addendum_images/page_9_11.png',
                'icon' => 'fa-toilet-paper',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Personal Care (Rollon Gel)',
                'slug' => 'personal-care-rollon',
                'description' => 'Signature luxury antiperspirant/deodorant combo gel roll-ons. Clear, strong, hypoallergenic, with 48 to 72 hours long-lasting sweat & odour protection.',
                'image' => 'storage/addendum_images/page_7_9.png',
                'icon' => 'fa-spray-can',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Natural Beauty Soap',
                'slug' => 'natural-beauty-soap',
                'description' => '100% natural botanical soaps including Curcumin-rich Turmeric and Cellular moisture Shea Butter bars.',
                'image' => 'storage/addendum_images/page_6_7.png',
                'icon' => 'fa-spa',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = ProductCategory::updateOrCreate(
                ['slug' => $c['slug']],
                $c
            );
        }

        // 3. Products
        $productsData = [
            // Category: Laundry Bar Soap (2)
            [
                'category_id' => $categories['laundry-bar-soap']->id,
                'name' => 'Aura Laundry Bar Soap (Blue) - 1 Kg',
                'slug' => 'aura-laundry-bar-soap-blue-1kg',
                'sku' => 'AUR-LND-1KG',
                'short_description' => 'High quality 1 Kg blue laundry care bar soap packed with active enzymes and surfactants for deep stain lifting without fabric residue.',
                'description' => "AURA’s Laundry Bar is of high quality, carefully crafted, scented, and well packaged. At Aura, we believe true luxury comes directly from using high quality natural oils. Our products are founded from a passion of holistic skin and laundry care, we blend pressed organic oils, soothing plant extracts, and essential oils into long lasting soaps that respect both your fabrics, skin and the earth.\n\nOur Laundry Soaps are high–performing cleaners, packed with active enzymes and surfactants. They effectively lift tough oil, dirt, and protein stains in different water temperatures. No residues left on fabrics, protects fabric colour and integrity.",
                'benefits' => "• Effectively lifts tough grease, dirt, and protein stains in hot and cold water\n• Safe for hand washing and delicate fabrics without skin irritation\n• Preserves vibrant fabric colors and fiber structural integrity\n• Long-lasting firm bar that does not melt quickly in water trays",
                'weight' => '1 Kg / Bar',
                'packaging_info' => 'Master Case of 24 Bars (1 Kg each)',
                'product_image' => 'storage/addendum_images/page_3_2.png',
                'wholesale_price' => 18.50,
                'min_order_qty' => 10,
                'wholesale_notes' => 'Case of 24 bars (1kg each). MSRP $1.20/bar.',
                'is_featured' => true,
                'status' => 'published',
                'sort_order' => 1,
            ],
            [
                'category_id' => $categories['laundry-bar-soap']->id,
                'name' => 'Aura Laundry Bar Soap (Yellow) - 250gm',
                'slug' => 'aura-laundry-bar-soap-yellow-250gm',
                'sku' => 'AUR-LND-250G',
                'short_description' => 'Compact 250gm yellow laundry cleansing bar with rich enzyme foam for everyday household wash and collar cleaning.',
                'description' => "Carefully formulated 250gm bar soap for everyday household laundry and quick garment washing. Powered by natural plant surfactants and active stain-lifting enzymes.",
                'benefits' => "• Quick foaming and effortless rinse\n• Protects hands with moisturizing botanical oils\n• Compact size easy to grip for collar and cuff scrubbing",
                'weight' => '250gm / Bar',
                'packaging_info' => 'Master Case of 48 Bars (250gm each)',
                'product_image' => 'storage/addendum_images/page_4_3.png',
                'wholesale_price' => 15.00,
                'min_order_qty' => 10,
                'wholesale_notes' => 'Case of 48 bars (250gm each). MSRP $0.50/bar.',
                'is_featured' => true,
                'status' => 'published',
                'sort_order' => 2,
            ],

            // Category: Toilet Bath Soap (1)
            [
                'category_id' => $categories['toilet-bath-soap']->id,
                'name' => 'Aura Toilet Bath Soap (High TFM 70-76%)',
                'slug' => 'aura-toilet-bath-soap-high-tfm',
                'sku' => 'AUR-BTH-150G',
                'short_description' => 'Premium cleansing bath soap with high Total Fatty Matter (TFM) 70-76% that cleanses richly without stripping natural skin oils.',
                'description' => "A high–quality, premium cleansing Bar Soap with a high Total Fatty Matter (TFM) of 70 – 76%. Our Toilet (Bath) Soap lathers easily and richly, cleans dirt effectively without stripping natural skin oils and moisture, retains beneficial natural glycerine, and leaves a light pleasant scent on the skin.",
                'benefits' => "• Grade 1 Soap formulation with High TFM (70-76%)\n• Rich, creamy lather that gently purifies skin\n• Retains natural vegetable glycerine for skin hydration\n• Subtle, long-lasting artisan fragrance",
                'weight' => '150gm / Bar',
                'packaging_info' => 'Master Case of 36 Bars (Individually wrapped)',
                'product_image' => 'storage/addendum_images/page_4_4.png',
                'wholesale_price' => 24.00,
                'min_order_qty' => 10,
                'wholesale_notes' => 'Case of 36 bars (High TFM). MSRP $1.00/bar.',
                'is_featured' => true,
                'status' => 'published',
                'sort_order' => 3,
            ],

            // Category: Natural Beauty Soap (2)
            [
                'category_id' => $categories['natural-beauty-soap']->id,
                'name' => 'Aura Turmeric Natural Beauty Soap',
                'slug' => 'aura-turmeric-natural-beauty-soap',
                'sku' => 'AUR-BTY-TURM',
                'short_description' => '100% natural botanical beauty bar powered by Curcumin to brighten dark spots, soothe acne inflammation, and fight aging free radicals.',
                'description' => "AURA’s Turmeric Natural Beauty Soap is a natural cleansing bar primarily used to smoothly brighten dark spots, calm acne–prone skin, and reduce skin inflammation. Its efficacy stems largely from Curcumin, an active compound in turmeric renowned for its potent antioxidant and anti-inflammatory properties.\n\nTurmeric and Shea Butter are 100% Natural Ingredients:\n- Fades hyperpigmentation: Curcumin inhibits excess melanin production, gradually reducing the contrast of dark spots, sun damage, and acne scars.\n- Combats breakouts: Natural antibacterial and antimicrobial qualities clear away impurities, neutralize acne-causing bacteria, and regulate excess sebum production.\n- Soothes inflammation: Calms redness, swelling, and irritation, providing relief for chronic skin conditions like eczema and psoriasis.\n- Anti-aging support: Dense antioxidants fight off environmental free radicals, helping to preserve skin elasticity and slow structural signs of aging.",
                'benefits' => "• Fades hyperpigmentation, sun damage, and acne scars\n• Combats breakouts with natural antibacterial Curcumin\n• Soothes eczema, psoriasis, and redness\n• Promotes an even, luminous, natural glow",
                'weight' => '100gm / Bar',
                'packaging_info' => 'Case of 24 Bars (In individual luxury retail carton)',
                'product_image' => 'storage/addendum_images/page_6_7.png',
                'wholesale_price' => 28.00,
                'min_order_qty' => 5,
                'wholesale_notes' => 'Case of 24 beauty bars. MSRP $2.00/bar.',
                'is_featured' => true,
                'status' => 'published',
                'sort_order' => 4,
            ],
            [
                'category_id' => $categories['natural-beauty-soap']->id,
                'name' => 'Aura Shea Butter Natural Beauty Soap',
                'slug' => 'aura-shea-butter-natural-beauty-soap',
                'sku' => 'AUR-BTY-SHEA',
                'short_description' => '100% natural organic raw shea butter cellular moisture bar providing intensive skin barrier repair and silky softness.',
                'description' => "Crafted with unrefined Grade-A Shea Butter, rich in essential fatty acids and vitamins A, E & F. Deeply hydrates dry and sensitive skin, boosts collagen production, and locks in natural cellular moisture.",
                'benefits' => "• Deep cellular moisture for dry and irritated skin\n• Rich in natural vitamins A & E for skin rejuvenation\n• Non-comedogenic and hypoallergenic\n• Creates a silky protective barrier against harsh weather",
                'weight' => '100gm / Bar',
                'packaging_info' => 'Case of 24 Bars (In individual luxury retail carton)',
                'product_image' => 'storage/addendum_images/page_6_7.png',
                'wholesale_price' => 30.00,
                'min_order_qty' => 5,
                'wholesale_notes' => 'Case of 24 beauty bars. MSRP $2.00/bar.',
                'is_featured' => true,
                'status' => 'published',
                'sort_order' => 5,
            ],

            // Category: Personal Care Rollon (2)
            [
                'category_id' => $categories['personal-care-rollon']->id,
                'name' => 'Aura Antiperspirant / Deodorant Combo Rollon (Men - Blue)',
                'slug' => 'aura-antiperspirant-deodorant-rollon-men-blue',
                'sku' => 'AUR-ROL-MEN',
                'short_description' => 'Signature luxury antiperspirant & deodorant roll-on for men. Clear gel, no stains, no cloth discoloration, 48-72 hours heavy-duty protection.',
                'description' => "Our signature Antiperspirant/Deodorant Combo Rollon is clear, strong, no stains, no irritation, no cloth discolouration, and keeps you fresh for longer than 48 Hours. Even soldiers on duty for 72 hours can use it and remain fresh: No Sweating, No Odour.\n\nOur Antiperspirant/Deodorant Combo Gel Roll-ons provide a lightweight, smooth glide that prevents sweat and neutralizes body odour without leaving thick, white solid residues on your clothing. They are:\n- Quick - drying,\n- Stay completely hypoallergenic,\n- Safe for sensitive skin – with no irritation,\n- Long – lasting, up to 48 - 72 hours protection of odour and wetness,\n- No Parabens or dyes,\n- Your clothes remain soft and no hardness or tears after years of usage.\n\nAura Soaps has probably the best Packaging of all the Antiperspirant/Deodorants on the market today. Classic Luxury.",
                'benefits' => "• 48 to 72 Hours Clinical Grade Odour & Sweat Protection\n• Clear gel glide — ZERO white marks or shirt yellowing\n• Alcohol-free & Paraben-free — No burning or skin irritation\n• Premium luxury ergonomic bottle packaging",
                'weight' => '50ml Roll-on Bottle',
                'packaging_info' => 'Master Case of 24 Units (In presentation cartons)',
                'product_image' => 'storage/addendum_images/page_7_9.png',
                'wholesale_price' => 36.00,
                'min_order_qty' => 5,
                'wholesale_notes' => 'Case of 24 units (50ml). MSRP $2.50/unit.',
                'is_featured' => true,
                'status' => 'published',
                'sort_order' => 6,
            ],
            [
                'category_id' => $categories['personal-care-rollon']->id,
                'name' => 'Aura Antiperspirant / Deodorant Combo Rollon (Women - Red)',
                'slug' => 'aura-antiperspirant-deodorant-rollon-women-red',
                'sku' => 'AUR-ROL-WMN',
                'short_description' => 'Luxurious floral lavender clear antiperspirant & deodorant roll-on for women with 48-72 hours freshness and zero white marks.',
                'description' => "Our signature Antiperspirant/Deodorant Combo Rollon (Women) features a delicate floral lavender note and smooth invisible glide. Formulated without parabens or harsh dyes, it keeps you confidently dry and fresh for 48 to 72 hours without staining dresses or causing underarm darkening.",
                'benefits' => "• 48 to 72 Hours Long-lasting Freshness & Dryness\n• Delicate soothing floral fragrance\n• Invisible clear gel — No white chalky residue on black or colored clothing\n• Gentle on freshly shaved skin with calming aloe extracts",
                'weight' => '50ml Roll-on Bottle',
                'packaging_info' => 'Master Case of 24 Units (In presentation cartons)',
                'product_image' => 'storage/addendum_images/page_8_10.png',
                'wholesale_price' => 36.00,
                'min_order_qty' => 5,
                'wholesale_notes' => 'Case of 24 units (50ml). MSRP $2.50/unit.',
                'is_featured' => true,
                'status' => 'published',
                'sort_order' => 7,
            ],

            // Category: Luxury Toilet Paper (1)
            [
                'category_id' => $categories['luxury-toilet-paper']->id,
                'name' => 'Aura Luxury Toilet Paper (1 & 2-Ply 100% Virgin Pulp)',
                'slug' => 'aura-luxury-toilet-paper-virgin-pulp',
                'sku' => 'AUR-PPR-TLT',
                'short_description' => 'Thick, pillow-soft, silky smooth, highly absorbent 1 & 2-ply luxury toilet paper engineered to dissolve quickly and prevent plumbing clogs.',
                'description' => "AURA’S luxury toilet paper is thick, pillow–soft, silky smooth, strong, cushiony, and highly absorbent. It features 1–2 plies of white pure virgin wood pulp Fibers.\n\nThese paper qualities offer quality and structural strength without shedding lint or tearing during use:\n- Embossed quilting: Using air pockets and quilted patterns to maximize plushness and fluid collection\n- Lint–free finish: Specially processed to prevent pilling or residue buildup on the skin\n- Tear resistant: Retains wet strength without falling apart mid-use\n- Dermatologically safer: Fragrance-free, dye-free, and hypoallergenic for sensitive and baby skins\n- Easily flushes: Engineered to dissolve quickly in water and prevent plumbing and septic clogs.",
                'benefits' => "• 100% Pure Virgin Wood Pulp fibers\n• Pillow-soft embossed quilting for ultimate comfort\n• Rapid-dissolve flushability — Zero pipe blockages or septic clogs\n• Hypoallergenic and free of toxic chlorine bleaches",
                'weight' => '2-Ply / 200 Sheets per Roll',
                'packaging_info' => 'Master Pack of 24 Rolls / 10-Roll Packs',
                'product_image' => 'storage/addendum_images/page_5_5.png',
                'wholesale_price' => 16.50,
                'min_order_qty' => 10,
                'wholesale_notes' => 'Master case of 24 luxury rolls. High demand hospitality & retail product.',
                'is_featured' => true,
                'status' => 'published',
                'sort_order' => 8,
            ],

            // Category: Kitchen & Table Paper Towel (1)
            [
                'category_id' => $categories['kitchen-table-paper-towel']->id,
                'name' => 'Aura Kitchen & Table Paper Hand Towel (4-Rolls Pack)',
                'slug' => 'aura-kitchen-table-paper-hand-towel-4-pack',
                'sku' => 'AUR-PPR-KTN',
                'short_description' => 'Ultra-absorbent embossed kitchen and table hand paper towels for quick fluid collection, spill absorption, and hygienic table dining.',
                'description' => "Aura Kitchen & Table Paper Towels are engineered with high-strength quilted air-pockets that absorb spills instantly. Extra-thick and tear-resistant even when wet, perfect for modern kitchens, dining tables, restaurants, and hygiene-conscious households.",
                'benefits' => "• Maximum fluid absorption with honeycomb embossing\n• Extra wet-strength — Does not tear or shred during wiping\n• Food-contact safe and lint-free\n• 4 generous rolls per retail pack",
                'weight' => '4 Rolls Pack (100 Sheets/Roll)',
                'packaging_info' => 'Master Carton of 12 Packs (48 Total Rolls)',
                'product_image' => 'storage/addendum_images/page_9_11.png',
                'wholesale_price' => 18.00,
                'min_order_qty' => 10,
                'wholesale_notes' => 'Carton of 12 x 4-Packs. MSRP $2.20/pack.',
                'is_featured' => true,
                'status' => 'published',
                'sort_order' => 9,
            ],
        ];

        foreach ($productsData as $p) {
            Product::updateOrCreate(
                ['slug' => $p['slug']],
                $p
            );
        }

        // 4. Update Agent Locator Database with exact table from Addendum 2
        // Clean old mock locations and insert exact Addendum 2 table
        Agent::truncate();

        $locatorLocations = [
            // Rwanda - Kigali (20)
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Kigali City', 'city_town' => 'Kigali (Nyarugenge, Gasabo, Kicukiro)', 'agent_count' => 20, 'sort_order' => 1, 'status' => true],

            // Rwanda - Southern Province (24 Total)
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Southern', 'city_town' => 'Nyanza (Nyanza Town)', 'agent_count' => 2, 'sort_order' => 2, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Southern', 'city_town' => 'Gisagara (Ndora)', 'agent_count' => 2, 'sort_order' => 3, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Southern', 'city_town' => 'Nyaruguru (Kibeho)', 'agent_count' => 2, 'sort_order' => 4, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Southern', 'city_town' => 'Huye (Butare City)', 'agent_count' => 4, 'sort_order' => 5, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Southern', 'city_town' => 'Nyamagabe (Gasaka Town)', 'agent_count' => 2, 'sort_order' => 6, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Southern', 'city_town' => 'Ruhango (Ruhango City)', 'agent_count' => 4, 'sort_order' => 7, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Southern', 'city_town' => 'Muhanga (Gitarama/Muhanga City)', 'agent_count' => 4, 'sort_order' => 8, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Southern', 'city_town' => 'Kamonyi (Kamonyi City)', 'agent_count' => 4, 'sort_order' => 9, 'status' => true],

            // Rwanda - Western Province (22 Total)
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Western', 'city_town' => 'Karongi (Kibuye/Rubengera)', 'agent_count' => 3, 'sort_order' => 10, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Western', 'city_town' => 'Rutsiro (Gihango Town)', 'agent_count' => 2, 'sort_order' => 11, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Western', 'city_town' => 'Rubavu (Gisenyi City)', 'agent_count' => 4, 'sort_order' => 12, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Western', 'city_town' => 'Nyabihu (Mukamira Town)', 'agent_count' => 3, 'sort_order' => 13, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Western', 'city_town' => 'Ngororero (Ngororero Town)', 'agent_count' => 2, 'sort_order' => 14, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Western', 'city_town' => 'Rusizi (Kamembe City)', 'agent_count' => 4, 'sort_order' => 15, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Western', 'city_town' => 'Nyamasheke (Kagano/Cyangugu)', 'agent_count' => 4, 'sort_order' => 16, 'status' => true],

            // Rwanda - Northern Province (14 Total)
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Northern', 'city_town' => 'Rulindo (Tare Town)', 'agent_count' => 3, 'sort_order' => 17, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Northern', 'city_town' => 'Gakenke (Gakenke Town)', 'agent_count' => 2, 'sort_order' => 18, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Northern', 'city_town' => 'Musanze (Ruhengeri City)', 'agent_count' => 4, 'sort_order' => 19, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Northern', 'city_town' => 'Burera (Cyeru Town)', 'agent_count' => 3, 'sort_order' => 20, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Northern', 'city_town' => 'Gicumbi (Byumba Town)', 'agent_count' => 2, 'sort_order' => 21, 'status' => true],

            // Rwanda - Eastern Province (20 Total)
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Eastern', 'city_town' => 'Rwamagana (Rwamagana City)', 'agent_count' => 4, 'sort_order' => 22, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Eastern', 'city_town' => 'Nyagatare (Nyagatare City)', 'agent_count' => 4, 'sort_order' => 23, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Eastern', 'city_town' => 'Gatsibo (Kabarore Town)', 'agent_count' => 2, 'sort_order' => 24, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Eastern', 'city_town' => 'Kayonza (Kayonza Town)', 'agent_count' => 2, 'sort_order' => 25, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Eastern', 'city_town' => 'Kirehe (Rusumo)', 'agent_count' => 2, 'sort_order' => 26, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Eastern', 'city_town' => 'Ngoma (Kibungo)', 'agent_count' => 2, 'sort_order' => 27, 'status' => true],
            ['market' => 'rwanda', 'country' => 'rwanda', 'province_state' => 'Eastern', 'city_town' => 'Bugesera (Nyamata City)', 'agent_count' => 4, 'sort_order' => 28, 'status' => true],

            // Regional: Great Lakes Market - DRC (14 Total)
            ['market' => 'regional', 'country' => 'drc', 'province_state' => 'North Kivu', 'city_town' => 'DRC (Goma City)', 'agent_count' => 4, 'sort_order' => 29, 'status' => true],
            ['market' => 'regional', 'country' => 'drc', 'province_state' => 'South Kivu', 'city_town' => 'DRC (Bukavu City)', 'agent_count' => 4, 'sort_order' => 30, 'status' => true],
            ['market' => 'regional', 'country' => 'drc', 'province_state' => 'South Kivu', 'city_town' => 'DRC (Uvira City)', 'agent_count' => 4, 'sort_order' => 31, 'status' => true],
            ['market' => 'regional', 'country' => 'drc', 'province_state' => 'Ituri', 'city_town' => 'DRC (Bunia)', 'agent_count' => 2, 'sort_order' => 32, 'status' => true],

            // Regional: Great Lakes Market - Uganda (21 Total)
            ['market' => 'regional', 'country' => 'uganda', 'province_state' => 'Western Uganda', 'city_town' => 'Uganda (Kabale)', 'agent_count' => 2, 'sort_order' => 33, 'status' => true],
            ['market' => 'regional', 'country' => 'uganda', 'province_state' => 'Western Uganda', 'city_town' => 'Uganda (Kisoro)', 'agent_count' => 2, 'sort_order' => 34, 'status' => true],
            ['market' => 'regional', 'country' => 'uganda', 'province_state' => 'Western Uganda', 'city_town' => 'Uganda (Mbarara City)', 'agent_count' => 3, 'sort_order' => 35, 'status' => true],
            ['market' => 'regional', 'country' => 'uganda', 'province_state' => 'Western Uganda', 'city_town' => 'Uganda (Rukungiri)', 'agent_count' => 2, 'sort_order' => 36, 'status' => true],
            ['market' => 'regional', 'country' => 'uganda', 'province_state' => 'Western Uganda', 'city_town' => 'Uganda (Ibanda)', 'agent_count' => 2, 'sort_order' => 37, 'status' => true],
            ['market' => 'regional', 'country' => 'uganda', 'province_state' => 'Western Uganda', 'city_town' => 'Uganda (Bushenyi)', 'agent_count' => 2, 'sort_order' => 38, 'status' => true],
            ['market' => 'regional', 'country' => 'uganda', 'province_state' => 'Western Uganda', 'city_town' => 'Uganda (Isingiro)', 'agent_count' => 2, 'sort_order' => 39, 'status' => true],
            ['market' => 'regional', 'country' => 'uganda', 'province_state' => 'Western Uganda', 'city_town' => 'Uganda (Kanungu)', 'agent_count' => 2, 'sort_order' => 40, 'status' => true],
            ['market' => 'regional', 'country' => 'uganda', 'province_state' => 'Western Uganda', 'city_town' => 'Uganda (Kiruhura)', 'agent_count' => 2, 'sort_order' => 41, 'status' => true],
            ['market' => 'regional', 'country' => 'uganda', 'province_state' => 'Western Uganda', 'city_town' => 'Uganda (Ntungamo)', 'agent_count' => 2, 'sort_order' => 42, 'status' => true],
            ['market' => 'regional', 'country' => 'uganda', 'province_state' => 'Western Uganda', 'city_town' => 'Uganda (Sheema – Kibingo)', 'agent_count' => 1, 'sort_order' => 43, 'status' => true],

            // Regional: Great Lakes Market - Tanzania (1 Total)
            ['market' => 'regional', 'country' => 'tanzania', 'province_state' => 'Kagera Region', 'city_town' => 'Tanzania (Rusumo Border)', 'agent_count' => 1, 'sort_order' => 44, 'status' => true],
        ];

        foreach ($locatorLocations as $loc) {
            Agent::create($loc);
        }
    }
}
