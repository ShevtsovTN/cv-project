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
        Schema::create('provider_site', static function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('external_id');

            $table->timestamps();

            $table->foreignId('provider_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('site_id')
                ->constrained()
                ->onDelete('cascade');

            $table->index('provider_id');
            $table->index('site_id');
            $table->index('active');
            $table->unique(['provider_id', 'site_id', 'external_id'], 'unique_provider_site');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_site');
    }
};
