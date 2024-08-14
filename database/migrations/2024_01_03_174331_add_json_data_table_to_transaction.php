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
        Schema::table('a_p_i_transactions', function (Blueprint $table) {
            //
            $table->text('data_json')->nullable();
            $table->string('status')->nullable()->default('success');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('a_p_i_transactions', function (Blueprint $table) {
            //
        });
    }
};
