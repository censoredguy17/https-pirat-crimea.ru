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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('listTitle');
            $table->string('listDescription');
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('textTop');
            $table->longText('textBottom');
            $table->boolean('is_published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->string('metaTitle');
            $table->string('metaDescription');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
