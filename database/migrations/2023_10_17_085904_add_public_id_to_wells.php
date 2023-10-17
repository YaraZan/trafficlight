<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('Well', function (Blueprint $table) {
            $table->uuid('public_id')->after('id')->unique()->default(Str::uuid());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Well', function (Blueprint $table) {
            $table->dropColumn('public_id');
        });
    }
};
