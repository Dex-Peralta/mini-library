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
        Schema::table('books', function (Blueprint $table) {
            $table->integer('total_copies')->default(0)->after('inventory_count');
            $table->integer('available_copies')->default(0)->after('total_copies');
            $table->text('description')->nullable()->after('title');
            $table->string('isbn')->nullable()->after('description');
            $table->integer('year_published')->nullable()->after('isbn');
            $table->string('genre')->nullable()->after('year_published');
            $table->string('publisher')->nullable()->after('genre');
            $table->string('cover_image')->nullable()->after('publisher');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['total_copies', 'available_copies', 'description', 'isbn', 'year_published', 'genre', 'publisher', 'cover_image']);
        });
    }
};
