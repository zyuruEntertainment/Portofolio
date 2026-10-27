<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->string('slug')->unique();
            $table->string('short_description', 300);
            $table->text('full_description');
            $table->string('logo_path');
            $table->string('preview_path')->nullable();
            $table->string('preview_type')->nullable();
            $table->string('status', 30);
            $table->string('github_url', 2048);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
