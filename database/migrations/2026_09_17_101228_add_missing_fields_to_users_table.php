<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'avatar_path')) {
                $table->string('avatar_path')->nullable();
            }
            if (!Schema::hasColumn('users', 'about')) {
                $table->string('about')->nullable();
            }
            if (!Schema::hasColumn('users', 'last_seen_at')) {
                $table->timestamp('last_seen_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'is_online')) {
                $table->boolean('is_online')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('users', 'avatar_path')) $columns[] = 'avatar_path';
            if (Schema::hasColumn('users', 'about')) $columns[] = 'about';
            if (Schema::hasColumn('users', 'last_seen_at')) $columns[] = 'last_seen_at';
            if (Schema::hasColumn('users', 'is_online')) $columns[] = 'is_online';

            if (count($columns) > 0) {
                $table->dropColumn($columns);
            }
        });
    }
};
