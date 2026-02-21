<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('domain_monitors', function (Blueprint $table) {
            $table->dateTime('last_checked_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('domain_monitors', function (Blueprint $table) {
            $table->dropColumn('last_checked_at');
        });
    }
};
