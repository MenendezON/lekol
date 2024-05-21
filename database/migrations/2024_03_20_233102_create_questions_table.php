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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->string('category');
            $table->text('question_text');
            $table->text('fait_seul');
            $table->text('avec_aide');
            $table->text('fait_pas');
            $table->timestamps();

            $table->foreign('survey_id')->references('id')->on('surveys')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};