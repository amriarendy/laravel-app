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
        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('favicon')->nullable();
            $table->string('keywords')->nullable();
            $table->string('author')->nullable();
            $table->string('image')->nullable();
            $table->string('copyright')->nullable();
            $table->string('sitename')->nullable();
            $table->string('robots')->nullable();
            $table->string('googlebot')->nullable();
            $table->string('googlebotnews')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metas');
    }
};
