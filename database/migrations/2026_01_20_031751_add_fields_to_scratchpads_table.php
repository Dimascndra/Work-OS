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
        Schema::table('scratchpads', function (Blueprint $table) {
            $table->string('title')->nullable()->default('Untitled Note');
            $table->string('color')->default('warning'); // warning, primary, danger, etc.
            $table->integer('position')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scratchpads', function (Blueprint $table) {
            //
        });
    }
};
