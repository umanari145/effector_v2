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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->string('shipping_name', 20);
            $table->string('shipping_kana', 20);
            $table->string('shipping_tel', 15);
            $table->string('shipping_zip', 8);
            $table->string('shipping_prefecture', 5);
            $table->string('shipping_city', 10);
            $table->string('shipping_address', 100);
            $table->string('shipping_building', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
