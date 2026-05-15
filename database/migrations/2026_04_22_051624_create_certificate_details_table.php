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
        Schema::create('certificate_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('certificate_type_id');
            $table->foreign('certificate_type_id')->references('id')->on('certificate_types')->onDelete('cascade');
            $table->unsignedBigInteger('official_id');
            $table->foreign('official_id')->references('id')->on('officials')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_details');
    }
};
