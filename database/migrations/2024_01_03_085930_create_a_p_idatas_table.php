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
        Schema::create('a_p_idatas', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('network_type')->nullable();
            $table->string('network_id')->nullable();
            $table->string('network_name')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_p_idatas');
    }
};
