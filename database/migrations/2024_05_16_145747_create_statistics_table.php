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
        Schema::create('statistics', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('site_id');
            $table->unsignedInteger('collected_at');
            $table->date('collected_date');
            $table->bigInteger('impressions')->default(0);
            $table->decimal('revenue', 15, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('site_id')
                ->references('id')
                ->on('sites')
                ->onDelete('cascade');

            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade');

            $table->index('collected_at');
            $table->index('collected_date');
            $table->index('site_id');
            $table->index('provider_id');

            $table->unique(['provider_id', 'collected_date', 'site_id'], 'unique_statistics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_statistics');
    }
};
