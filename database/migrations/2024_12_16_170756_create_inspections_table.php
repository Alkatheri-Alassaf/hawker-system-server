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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id("inspectionID");
            $table->unsignedBigInteger("applicationID");
            $table->unsignedBigInteger("inspectionOfficerID");
            $table->string("inspectionDate");
            $table->string("inspectionReportPath")->nullable(true);
            $table->timestamps();

            $table->foreign("applicationID")->references("applicationID")->on("applications")->onDelete("cascade");
            $table->foreign("inspectionOfficerID")->references("inspectionOfficerID")->on("inspection_officers")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
