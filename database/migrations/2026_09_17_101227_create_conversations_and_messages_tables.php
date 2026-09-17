<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('conversations')) {
            Schema::create('conversations', function (Blueprint $table) {
                $table->id();
                $table->boolean('is_group')->default(false);
                $table->string('name')->nullable();
                $table->unsignedBigInteger('last_message_id')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
                $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
                $table->text('content')->nullable();
                $table->string('image_path')->nullable();
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('conversation_user')) {
            Schema::create('conversation_user', function (Blueprint $table) {
                $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
                $table->primary(['conversation_id', 'user_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('conversation_user');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
    }
};
