<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add wholesale fields to products table if not present
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'wholesale_price')) {
                $table->decimal('wholesale_price', 10, 2)->nullable()->after('tags');
            }
            if (!Schema::hasColumn('products', 'min_order_qty')) {
                $table->integer('min_order_qty')->default(1)->after('wholesale_price');
            }
            if (!Schema::hasColumn('products', 'wholesale_notes')) {
                $table->string('wholesale_notes')->nullable()->after('min_order_qty');
            }
        });

        // 2. Agent Profiles (Principal Agents)
        if (!Schema::hasTable('agent_profiles')) {
            Schema::create('agent_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('agent_code')->unique()->nullable(); // e.g., AS-AGT-1001
                $table->string('company_name');
                $table->string('business_type')->default('wholesaler'); // wholesaler, retailer, distributor, independent_agent
                $table->text('business_address');
                $table->string('city');
                $table->string('province_state')->nullable();
                $table->string('country')->default('Rwanda');
                $table->string('whatsapp_number')->nullable();
                $table->string('national_id_number')->nullable();
                $table->text('business_details')->nullable();
                $table->text('buyer_network_info')->nullable();
                $table->string('expected_order_volume')->nullable();
                $table->text('distribution_requirements')->nullable();
                
                // Verification Documents
                $table->string('business_reg_doc')->nullable();
                $table->string('id_card_doc')->nullable();
                $table->string('agreement_doc')->nullable();

                // Status & Approvals
                $table->enum('application_status', ['pending', 'under_review', 'approved', 'rejected', 'suspended'])->default('pending');
                $table->enum('gov_tender_permission', ['not_permitted', 'requested', 'approved'])->default('not_permitted');
                $table->text('gov_tender_notes')->nullable();
                $table->text('admin_internal_notes')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');

                $table->timestamps();
            });
        }

        // 3. Agent Clients / Buyers
        if (!Schema::hasTable('agent_clients')) {
            Schema::create('agent_clients', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Agent
                $table->string('name');
                $table->string('company_name')->nullable();
                $table->enum('client_type', ['wholesaler', 'retailer'])->default('retailer');
                $table->string('phone');
                $table->string('whatsapp')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->string('city')->nullable();
                $table->string('country')->default('Rwanda');
                $table->text('notes')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->timestamps();
            });
        }

        // 4. Agent Enquiries
        if (!Schema::hasTable('agent_enquiries')) {
            Schema::create('agent_enquiries', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Agent
                $table->foreignId('client_id')->nullable()->constrained('agent_clients')->onDelete('set null');
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('product_interests')->nullable();
                $table->string('estimated_quantity')->nullable();
                $table->enum('status', ['new', 'contacted', 'follow_up', 'converted', 'closed'])->default('new');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 5. Agent Orders
        if (!Schema::hasTable('agent_orders')) {
            Schema::create('agent_orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_number')->unique(); // e.g. AS-ORD-2026-0001
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Agent
                $table->foreignId('client_id')->nullable()->constrained('agent_clients')->onDelete('set null');
                $table->enum('order_source', ['portal', 'phone', 'email', 'whatsapp'])->default('portal');
                $table->enum('status', ['pending', 'under_review', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
                $table->date('required_delivery_date')->nullable();
                $table->text('shipping_address')->nullable();
                $table->text('notes')->nullable();
                $table->text('financial_notes')->nullable();
                $table->text('admin_notes')->nullable();
                $table->decimal('subtotal', 12, 2)->default(0);
                $table->decimal('tax_amount', 12, 2)->default(0);
                $table->decimal('shipping_amount', 12, 2)->default(0);
                $table->decimal('total_amount', 12, 2)->default(0);
                $table->string('currency', 10)->default('USD');
                $table->timestamps();
            });
        }

        // 6. Agent Order Items
        if (!Schema::hasTable('agent_order_items')) {
            Schema::create('agent_order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('agent_orders')->onDelete('cascade');
                $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
                $table->string('product_name');
                $table->decimal('unit_price', 10, 2)->default(0);
                $table->integer('quantity')->default(1);
                $table->decimal('subtotal', 12, 2)->default(0);
                $table->timestamps();
            });
        }

        // 7. Agent Marketing Materials
        if (!Schema::hasTable('agent_marketing_materials')) {
            Schema::create('agent_marketing_materials', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->enum('category', ['catalogue', 'poster', 'spec_sheet', 'training', 'brochure', 'photo'])->default('catalogue');
                $table->text('description')->nullable();
                $table->string('file_path');
                $table->string('file_type')->nullable(); // pdf, jpg, png, docx, etc.
                $table->unsignedBigInteger('file_size')->default(0); // in bytes
                $table->string('thumbnail_path')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // 8. Agent Support Tickets
        if (!Schema::hasTable('agent_support_tickets')) {
            Schema::create('agent_support_tickets', function (Blueprint $table) {
                $table->id();
                $table->string('ticket_number')->unique(); // e.g. TCK-1001
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Agent
                $table->string('subject');
                $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
                $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
                $table->timestamp('last_reply_at')->nullable();
                $table->timestamps();
            });
        }

        // 9. Agent Support Messages
        if (!Schema::hasTable('agent_support_messages')) {
            Schema::create('agent_support_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ticket_id')->constrained('agent_support_tickets')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->boolean('is_admin_reply')->default(false);
                $table->text('message');
                $table->string('attachment_path')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_support_messages');
        Schema::dropIfExists('agent_support_tickets');
        Schema::dropIfExists('agent_marketing_materials');
        Schema::dropIfExists('agent_order_items');
        Schema::dropIfExists('agent_orders');
        Schema::dropIfExists('agent_enquiries');
        Schema::dropIfExists('agent_clients');
        Schema::dropIfExists('agent_profiles');

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'wholesale_price')) {
                $table->dropColumn(['wholesale_price']);
            }
            if (Schema::hasColumn('products', 'min_order_qty')) {
                $table->dropColumn(['min_order_qty']);
            }
            if (Schema::hasColumn('products', 'wholesale_notes')) {
                $table->dropColumn(['wholesale_notes']);
            }
        });
    }
};
