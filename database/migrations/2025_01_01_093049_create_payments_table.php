<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id("paymentID");
            $table->unsignedBigInteger("hawkerID");
            $table->unsignedBigInteger("applicationID");
            $table->double("amount");
            $table->string("cardNumber");
            $table->string("cardExpiryDate");
            $table->string("cardCVVNumber");
            $table->string("paymentStatus");
            $table->timestamps();

            $table->foreign("hawkerID")->references("hawkerID")->on("hawkers")->onDelete("cascade");
            $table->foreign("applicationID")->references("applicationID")->on("applications")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
