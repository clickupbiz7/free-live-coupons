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
        // ✅ check karo pehle column exist to nahi
        if (!Schema::hasColumn('stores', 'status')) {

            Schema::table('stores', function (Blueprint $table) {
                $table->boolean('status')->default(1);
            });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ✅ safely drop karo agar exist karta ho
        if (Schema::hasColumn('stores', 'status')) {

            Schema::table('stores', function (Blueprint $table) {
                $table->dropColumn('status');
            });

        }
    }
};