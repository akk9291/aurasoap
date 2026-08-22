<?php

namespace Database\Seeders;

use App\Models\AgentClient;
use App\Models\AgentEnquiry;
use App\Models\AgentMarketingMaterial;
use App\Models\AgentOrder;
use App\Models\AgentOrderItem;
use App\Models\AgentProfile;
use App\Models\AgentSupportMessage;
use App\Models\AgentSupportTicket;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AgentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Principal Agent Role exists
        $agentRole = Role::firstOrCreate(
            ['slug' => 'principal-agent'],
            [
                'name' => 'Principal Agent',
                'description' => 'Aura Soaps approved regional or national principal agent.'
            ]
        );

        // 2. Update existing products with wholesale prices & MOQ
        $wholesaleData = [
            'laundry' => ['price' => 18.50, 'moq' => 10, 'notes' => 'Box of 24 bars (1kg each). Pallet discounts available.'],
            'toilet' => ['price' => 24.00, 'moq' => 10, 'notes' => 'High TFM 70-76%. Case of 36 bars.'],
            'beauty' => ['price' => 30.00, 'moq' => 5, 'notes' => 'Natural botanical anti-acne bar. Case of 24 units.'],
            'shea' => ['price' => 30.00, 'moq' => 5, 'notes' => 'Cellular moisture formulation. Case of 24 units.'],
            'turmeric' => ['price' => 28.00, 'moq' => 5, 'notes' => 'Organic extract soap. Case of 24 units.'],
        ];

        $products = Product::all();
        foreach ($products as $index => $prod) {
            $assignedPrice = 20.00 + ($index * 3.50);
            $assignedMoq = 5;
            $notes = 'Wholesale agent rate per case. Standard 10-day payment term.';

            foreach ($wholesaleData as $key => $data) {
                if (stripos($prod->name, $key) !== false) {
                    $assignedPrice = $data['price'];
                    $assignedMoq = $data['moq'];
                    $notes = $data['notes'];
                    break;
                }
            }

            $prod->update([
                'wholesale_price' => $prod->wholesale_price ?? $assignedPrice,
                'min_order_qty' => $prod->min_order_qty ?? $assignedMoq,
                'wholesale_notes' => $prod->wholesale_notes ?? $notes,
            ]);
        }

        // 3. Seed Marketing Materials
        $marketingItems = [
            [
                'title' => 'Aura Soaps Full Product Catalogue (2026 Edition)',
                'category' => 'catalogue',
                'description' => 'Comprehensive product master catalogue featuring ingredients, packaging specifications, and master case dimensions.',
                'file_path' => 'assets/docs/aura-product-catalogue-2026.pdf',
                'file_type' => 'pdf',
                'file_size' => 4823450,
                'sort_order' => 1,
            ],
            [
                'title' => 'Principal Agent Wholesale Pricing & Volume Rebates Sheet',
                'category' => 'spec_sheet',
                'description' => 'Official pricing matrix, minimum order requirements (MOQ), and container load shipping guidelines.',
                'file_path' => 'assets/docs/aura-wholesale-pricing-matrix.pdf',
                'file_type' => 'pdf',
                'file_size' => 1250000,
                'sort_order' => 2,
            ],
            [
                'title' => 'Retail Promotional Poster - Turmeric & Shea Butter Range (A2)',
                'category' => 'poster',
                'description' => 'High-resolution printable promotional poster for retail displays, supermarkets, and beauty shop frontages.',
                'file_path' => 'assets/images/posters/aura-botanicals-poster-a2.jpg',
                'file_type' => 'jpg',
                'file_size' => 8420000,
                'sort_order' => 3,
            ],
            [
                'title' => 'Agent Sales & Customer Objection Handling Manual',
                'category' => 'training',
                'description' => 'Educational material guiding Principal Agents on key differentiators, TFM levels, and cold-process benefits.',
                'file_path' => 'assets/docs/agent-sales-training-manual.pdf',
                'file_type' => 'pdf',
                'file_size' => 2890000,
                'sort_order' => 4,
            ],
            [
                'title' => 'Wholesale Brochure & Product Specification Sheets',
                'category' => 'brochure',
                'description' => 'Compact 4-page brochure ready to print or email directly to retail store procurement managers.',
                'file_path' => 'assets/docs/aura-wholesale-brochure.pdf',
                'file_type' => 'pdf',
                'file_size' => 3120000,
                'sort_order' => 5,
            ],
            [
                'title' => 'High-Resolution Brand & Product Photos Pack (Zip)',
                'category' => 'photo',
                'description' => 'E-commerce white background and lifestyle photos for agent marketing campaigns and social media channels.',
                'file_path' => 'assets/media/aura-highres-photos.zip',
                'file_type' => 'zip',
                'file_size' => 15728640,
                'sort_order' => 6,
            ],
        ];

        foreach ($marketingItems as $item) {
            AgentMarketingMaterial::firstOrCreate(
                ['title' => $item['title']],
                $item
            );
        }

        // 4. Seed an Approved Principal Agent
        $adminUser = User::whereHas('roles', fn($q) => $q->where('slug', 'super-admin'))->first();

        $agentUser = User::firstOrCreate(
            ['email' => 'agent@aurasoaps.com'],
            [
                'name' => 'Jean-Paul Habimana',
                'phone' => '+250 788 123 456',
                'password' => Hash::make('Password123!'),
                'status' => 'active',
            ]
        );

        if (!$agentUser->hasRole('principal-agent')) {
            $agentUser->roles()->attach($agentRole->id);
        }

        $agentProfile = AgentProfile::firstOrCreate(
            ['user_id' => $agentUser->id],
            [
                'agent_code' => 'AS-AGT-1001',
                'company_name' => 'Great Lakes Distribution Ltd',
                'business_type' => 'wholesaler',
                'business_address' => 'Plot 45, Nyarugenge Commercial District, KN 7 Ave',
                'city' => 'Kigali',
                'province_state' => 'Kigali City',
                'country' => 'Rwanda',
                'whatsapp_number' => '+250 788 123 456',
                'national_id_number' => '1198580029384920',
                'business_details' => 'Leading FMCG distributor operating across central and northern provinces with 3 regional warehouses.',
                'buyer_network_info' => 'Network of over 120 supermarkets, minimarts, and independent retail soap stockists.',
                'expected_order_volume' => '1,500 - 3,000 cases per month',
                'distribution_requirements' => 'Requires quarterly scheduled deliveries and marketing promotional collateral.',
                'application_status' => 'approved',
                'gov_tender_permission' => 'not_permitted',
                'approved_at' => now(),
                'approved_by' => $adminUser ? $adminUser->id : null,
                'admin_internal_notes' => 'Verified warehouse and commercial registration on Feb 2026. Excellent distribution footprint.',
            ]
        );

        // Seed Sample Clients for Agent
        $client1 = AgentClient::firstOrCreate(
            ['user_id' => $agentUser->id, 'name' => 'Simba Supermarket Nyarugenge'],
            [
                'company_name' => 'Simba Supermarkets Ltd',
                'client_type' => 'wholesaler',
                'phone' => '+250 788 444 555',
                'whatsapp' => '+250 788 444 555',
                'email' => 'procurement@simbasupermarket.rw',
                'address' => 'City Center Branch, KN 4 Ave',
                'city' => 'Kigali',
                'country' => 'Rwanda',
                'notes' => 'Large retail chain with 6 locations. Orders every 2 weeks.',
                'status' => 'active',
            ]
        );

        $client2 = AgentClient::firstOrCreate(
            ['user_id' => $agentUser->id, 'name' => 'Rubavu Soap Mart'],
            [
                'company_name' => 'Rubavu Wholesale Traders',
                'client_type' => 'retailer',
                'phone' => '+250 783 777 888',
                'whatsapp' => '+250 783 777 888',
                'email' => 'orders@rubavuwholesalers.com',
                'address' => 'Main Market St, Near Border Post',
                'city' => 'Gisenyi / Rubavu',
                'country' => 'Rwanda',
                'notes' => 'Cross-border trading retail wholesaler. Highly interested in Laundry bars.',
                'status' => 'active',
            ]
        );

        // Seed Sample Enquiries
        AgentEnquiry::firstOrCreate(
            ['user_id' => $agentUser->id, 'title' => 'Inquiry for 100 cases Turmeric & Shea Butter Soap'],
            [
                'client_id' => $client1->id,
                'description' => 'Client wants quotation for introductory bulk order of beauty bars for 3 central branch outlets.',
                'product_interests' => 'Turmeric Soap, Shea Butter Bar',
                'estimated_quantity' => '100 cases (2,400 bars)',
                'status' => 'contacted',
                'notes' => 'Sent wholesale pricing sheet. Follow-up scheduled for next Tuesday.',
            ]
        );

        AgentEnquiry::firstOrCreate(
            ['user_id' => $agentUser->id, 'title' => 'Laundry Bar Soap 1Kg Bulk Supply'],
            [
                'client_id' => $client2->id,
                'description' => 'Wholesaler looking to stock 250 cases for northern district supply.',
                'product_interests' => 'Laundry Bar Soap 1Kg',
                'estimated_quantity' => '250 cases',
                'status' => 'new',
                'notes' => 'New buyer enquiry received via WhatsApp.',
            ]
        );

        // Seed Sample Order
        $sampleProd1 = Product::first();
        $sampleProd2 = Product::skip(1)->first();

        $order = AgentOrder::firstOrCreate(
            ['order_number' => 'AS-ORD-2026-0001'],
            [
                'user_id' => $agentUser->id,
                'client_id' => $client1->id,
                'order_source' => 'portal',
                'status' => 'confirmed',
                'required_delivery_date' => now()->addDays(7)->toDateString(),
                'shipping_address' => 'Simba Supermarkets Central Distribution Center, Masoro Special Economic Zone, Kigali',
                'notes' => 'Delivery required before month end promotions. Please provide palletized packaging.',
                'financial_notes' => 'Payment via Bank Wire against Proforma Invoice.',
                'subtotal' => 970.00,
                'tax_amount' => 0.00,
                'shipping_amount' => 50.00,
                'total_amount' => 1020.00,
                'currency' => 'USD',
            ]
        );

        if ($sampleProd1 && $order->items()->count() === 0) {
            AgentOrderItem::create([
                'order_id' => $order->id,
                'product_id' => $sampleProd1->id,
                'product_name' => $sampleProd1->name,
                'unit_price' => $sampleProd1->wholesale_price ?? 18.50,
                'quantity' => 30,
                'subtotal' => ($sampleProd1->wholesale_price ?? 18.50) * 30,
            ]);
        }

        if ($sampleProd2 && $order->items()->count() === 1) {
            AgentOrderItem::create([
                'order_id' => $order->id,
                'product_id' => $sampleProd2->id,
                'product_name' => $sampleProd2->name,
                'unit_price' => $sampleProd2->wholesale_price ?? 24.00,
                'quantity' => 15,
                'subtotal' => ($sampleProd2->wholesale_price ?? 24.00) * 15,
            ]);
        }

        // Seed Sample Support Ticket
        $ticket = AgentSupportTicket::firstOrCreate(
            ['ticket_number' => 'TCK-1001'],
            [
                'user_id' => $agentUser->id,
                'subject' => 'Request for Co-branded Shelf Banners for Simba Supermarket',
                'priority' => 'normal',
                'status' => 'open',
                'last_reply_at' => now(),
            ]
        );

        if ($ticket->messages()->count() === 0) {
            AgentSupportMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => $agentUser->id,
                'is_admin_reply' => false,
                'message' => 'Hello Aura Management team. Our retail client Simba Supermarket has approved shelf space for 5 branches. Can you supply branded shelf-talkers and price wobblers for the new botanical soap line?',
            ]);
        }

        // 5. Seed a Pending Agent Application for Admin review testing
        $pendingUser = User::firstOrCreate(
            ['email' => 'applicant.kamali@gmail.com'],
            [
                'name' => 'Kamali Eric',
                'phone' => '+250 782 999 111',
                'password' => Hash::make('Password123!'),
                'status' => 'active',
            ]
        );

        if (!$pendingUser->hasRole('principal-agent')) {
            $pendingUser->roles()->attach($agentRole->id);
        }

        AgentProfile::firstOrCreate(
            ['user_id' => $pendingUser->id],
            [
                'agent_code' => null, // Pending approval
                'company_name' => 'Eastern Province Trade Hub',
                'business_type' => 'distributor',
                'business_address' => 'Rwamagana Main Commercial Center, Plot 12',
                'city' => 'Rwamagana',
                'province_state' => 'Eastern Province',
                'country' => 'Rwanda',
                'whatsapp_number' => '+250 782 999 111',
                'national_id_number' => '1199080034567890',
                'business_details' => 'Wholesale supplier distributing toiletries, soaps and household items to over 40 shops in Rwamagana and Kayonza.',
                'buyer_network_info' => 'Direct supply to 40 retail kiosks and 5 institutional boarding schools.',
                'expected_order_volume' => '500 - 1,000 cases monthly',
                'distribution_requirements' => 'Delivery directly to Rwamagana hub.',
                'application_status' => 'pending',
                'gov_tender_permission' => 'not_permitted',
            ]
        );
    }
}
