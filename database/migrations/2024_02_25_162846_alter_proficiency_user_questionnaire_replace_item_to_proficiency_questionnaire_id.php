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
        Schema::table('proficiency_user_questionnaires', function (Blueprint $table) {
            $table->unsignedBigInteger('proficiency_questionnaire_id')->after('proficiency_user_id');
            $table->dropColumn('item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proficiency_user_questionnaires', function (Blueprint $table) {
            $table->dropColumn('proficiency_questionnaire_id');
            $table->string('item',25);
        });
    }
};
