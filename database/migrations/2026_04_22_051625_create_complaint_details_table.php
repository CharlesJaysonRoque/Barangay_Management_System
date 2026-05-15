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
        Schema::create('complaint_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complainant_id');
            $table->foreign('complainant_id')->references('id')->on('residents')->onDelete('cascade');
            $table->unsignedBigInteger('accused_id');
            $table->foreign('accused_id')->references('id')->on('residents')->onDelete('cascade');
            $table->unsignedBigInteger('complaint_type_id');
            $table->foreign('complaint_type_id')->references('id')->on('complaint_types')->onDelete('cascade');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_details');
    }
};
