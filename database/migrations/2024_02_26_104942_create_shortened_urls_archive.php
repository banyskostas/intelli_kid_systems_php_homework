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
        Schema::create('shortened_urls_archive', function (Blueprint $table) {
            $table->id();

            $table->text('url');
            $table->string('short_url', 6);
            $table->dateTime('valid_until');
            $table->boolean('is_manually_deleted')->default(0);

            $table->dateTime('created_at');
            $table->dateTime('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortened_urls_archive');
    }
};
