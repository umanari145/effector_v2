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
            $table->string('name', 20);
            $table->string('kana', 20);
            $table->string('tel', 15);
            $table->string('email', 100);
            $table->string('zip', 8);
            $table->string('prefecture', 5);
            $table->string('city', 10);
            $table->string('address', 100);
            $table->string('building', 100);
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
