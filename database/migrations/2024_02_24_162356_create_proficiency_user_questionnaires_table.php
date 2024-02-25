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
        Schema::create('proficiency_user_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proficiency_user_id');
            $table->string('item');
            $table->integer('value')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proficiency_user_questionnaires');
    }
};
