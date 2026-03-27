<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            // Связь с основной таблицей контента
            $table->foreignId('content_id')->constrained('contents')->onDelete('cascade');

            $table->string('title')->nullable(); // Название видео
            $table->text('iframe');             // Код вставки (YouTube, Rutube и т.д.)

            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0); // Порядок сортировки

            $table->timestamp('published_at')->nullable();
            $table->softDeletes(); // Поле deleted_at
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_videos');
    }
};
