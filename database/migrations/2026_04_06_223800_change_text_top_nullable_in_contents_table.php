<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->text('textTop')->nullable()->change();
            $table->text('textBottom')->nullable()->change();
            $table->text('metaTitle')->nullable()->change();
            $table->text('metaDescription')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->text('textTop')->nullable(false)->change();
            $table->text('textBottom')->nullable(false)->change();
            $table->text('metaTitle')->nullable(false)->change();
            $table->text('metaDescription')->nullable(false)->change();
        });
    }
};
