<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scoped_paths', function (Blueprint $table) {
            $table->id();
            $table->string('path_identifier', 50)->unique();
            $table->string('name', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('path_identifier');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scoped_paths');
    }
};