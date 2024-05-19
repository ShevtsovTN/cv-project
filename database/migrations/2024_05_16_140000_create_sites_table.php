<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sites', static function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->index();
            $table->string('url', 255)->unique();
            $table->string('provider_key', 255)->unique();

            $table->timestamps();

            $table->index(['name', 'provider_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
