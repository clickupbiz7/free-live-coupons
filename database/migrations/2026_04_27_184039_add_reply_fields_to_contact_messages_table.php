<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {

            $table->boolean('is_replied')
                  ->default(0)
                  ->after('message');

            $table->timestamp('replied_at')
                  ->nullable()
                  ->after('is_replied');

            $table->longText('reply_message')
                  ->nullable()
                  ->after('replied_at');

        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {

            $table->dropColumn([
                'is_replied',
                'replied_at',
                'reply_message'
            ]);

        });
    }
};