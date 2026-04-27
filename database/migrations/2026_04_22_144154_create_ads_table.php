<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {

            $table->id();

            $table->string('title')->nullable();

            $table->string('network')->nullable();
            // google / adsterra / monetag

            $table->string('placement')->nullable();
            // home_top, home_middle etc

            $table->string('size')->nullable();
            // 728x90 etc

            $table->string('device')->default('all');
            // all / mobile / desktop

            $table->integer('priority')->default(1);

            $table->longText('ad_code')->nullable();

            $table->tinyInteger('status')->default(1);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};