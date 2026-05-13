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
        Schema::create('domain_monitors', function (Blueprint $table) {
            $table->id();
            $table->string('domain_url');
            $table->dateTime('ssl_expires_at')->nullable();
            $table->dateTime('domain_expires_at')->nullable();
            $table->enum('status', ['healthy', 'down', 'warning'])->default('healthy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domain_monitors');
    }
};
