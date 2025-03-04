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
        Schema::table('orderinfo', function (Blueprint $table) {
            $table->enum('status', ['processing', 'delivered', 'canceled']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orderinfo', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
