<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('password')->nullable()->after('username');
            $table->text('public_key')->nullable()->after('private_key');
            $table->text('description')->nullable()->after('is_active');
        });

        // Migrate data from ssh_keys table if exists
        if (Schema::hasTable('ssh_keys')) {
            $sshKeys = DB::table('ssh_keys')->get();

            foreach ($sshKeys as $key) {
                DB::table('servers')->insert([
                    'title' => $key->title ?? 'Migrated: ' . $key->ip_server,
                    'name' => $key->title ?? $key->ip_server,
                    'ip_address' => $key->ip_server,
                    'port' => $key->port,
                    'username' => $key->username,
                    'password' => $key->password,
                    'public_key' => $key->public_key,
                    'os_type' => 'linux', // Default value
                    'is_active' => true,
                    'created_at' => $key->created_at,
                    'updated_at' => $key->updated_at,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->dropColumn(['title', 'password', 'public_key', 'description']);
        });
    }
};
