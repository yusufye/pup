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
        Schema::create('proficiency_user_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proficiency_user_commodity_id');
            $table->unsignedBigInteger('package_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proficiency_user_packages');
    }
};
