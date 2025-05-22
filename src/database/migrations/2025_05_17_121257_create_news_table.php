<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('image');
            $table->string('preview');
            $table->text('content');
            $table->fullText(['preview', 'content']);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
