<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'settings' => ['value'],
            'seo_metas' => ['title', 'meta_description', 'focus_keyword', 'og_title', 'og_description'],
            'products' => ['name', 'short_description', 'description', 'benefits', 'tags'],
            'product_categories' => ['name', 'description'],
            'ingredients' => ['name', 'short_description', 'full_description', 'benefits'],
            'blog_posts' => ['title', 'excerpt', 'content', 'tags'],
            'faqs' => ['question', 'answer'],
            'testimonials' => ['testimonial'],
            'process_steps' => ['title', 'description'],
        ];

        foreach ($tables as $table => $columns) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            foreach ($columns as $column) {
                if (!Schema::hasColumn($table, $column)) {
                    continue;
                }

                $rows = DB::table($table)
                    ->where($column, 'LIKE', '%handcrafted%')
                    ->orWhere($column, 'LIKE', '%Handcrafted%')
                    ->orWhere($column, 'LIKE', '%hand-crafted%')
                    ->orWhere($column, 'LIKE', '%Hand-crafted%')
                    ->get();

                foreach ($rows as $row) {
                    $original = $row->$column;
                    $replaced = preg_replace('/hand-crafted/i', 'crafted', $original);
                    $replaced = preg_replace('/Handcrafted/', 'Crafted', $replaced);
                    $replaced = preg_replace('/handcrafted/', 'crafted', $replaced);

                    DB::table($table)->where('id', $row->id)->update([$column => $replaced]);
                }
            }
        }
    }

    public function down(): void
    {
        // No reversal needed
    }
};
