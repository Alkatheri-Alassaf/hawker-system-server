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
        Schema::create('documents', function (Blueprint $table) {
            $table->id('documentID');
            $table->unsignedBigInteger('applicationID');
            $table->string('documentType');
            $table->string('documentName');
            $table->string('path');
            $table->timestamps();

            $table->foreign('applicationID')->references('applicationID')->on('applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
