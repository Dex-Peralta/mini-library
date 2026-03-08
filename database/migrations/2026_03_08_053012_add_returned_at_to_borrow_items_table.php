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
        Schema::table('borrow_items', function (Blueprint $table) {
            // Rename return_date to returned_at and change to datetime
            $table->renameColumn('return_date', 'returned_at');
        });
        
        // Change column type in separate statement
        Schema::table('borrow_items', function (Blueprint $table) {
            $table->dateTime('returned_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrow_items', function (Blueprint $table) {
            $table->date('returned_at')->nullable()->change();
        });
        
        Schema::table('borrow_items', function (Blueprint $table) {
            $table->renameColumn('returned_at', 'return_date');
        });
    }
};
