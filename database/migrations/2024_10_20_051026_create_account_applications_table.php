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
        Schema::create('account_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('full_name')->unique();
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('gender', ['Laki-laki', 'Wanita']);
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('village_id');
            $table->string('street_name');
            $table->decimal('deposit_amount', 15, 2);
            $table->enum('status', ['Menunggu Approval', 'Disetujui'])->default('Menunggu Approval');
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('restrict');
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('restrict');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('restrict');
            $table->foreign('village_id')->references('id')->on('villages')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_applications');
    }
};
