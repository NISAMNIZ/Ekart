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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('firstname');
            $table->string(column: 'lastname');
            $table->string(column: 'email');
            $table->string(column: 'mobile');
            $table->integer(column: 'country_id');
            $table->string(column: 'appartment')->nullable();
            $table->string(column: 'address');
            $table->string(column: 'city');
            $table->string(column: 'state');
            $table->string(column: 'zip');
            $table->text(column: 'notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
