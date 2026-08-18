<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('market')->default('rwanda'); // rwanda, regional
            $table->string('country')->default('rwanda'); // rwanda, drc, uganda, tanzania
            $table->string('city_town');
            $table->string('province_state');
            $table->integer('agent_count')->default(1);
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
