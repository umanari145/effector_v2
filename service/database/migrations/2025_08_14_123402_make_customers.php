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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('kana')->nullable();
            $table->string('tel')->nullable();
            $table->string('email');
            $table->string('zip');
            $table->text('address');
            $table->string('name_send')->nullable();
            $table->string('kana_send')->nullable();
            $table->string('zip_send')->nullable();
            $table->text('address_send')->nullable();
            $table->timestamp('buy_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};