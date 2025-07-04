<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('scoped_path_id')->nullable()->constrained('scoped_paths')->onDelete('set null');
            $table->index('scoped_path_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['scoped_path_id']);
            $table->dropColumn('scoped_path_id');
        });
    }
};