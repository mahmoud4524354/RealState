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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('ptype_id');
            $table->string('amenities_id');
            $table->string('property_name');
            $table->string('property_slug')->unique();
            $table->string('property_code')->unique();
            $table->enum('property_status', ['available', 'sold', 'pending'])->default('available');
            $table->decimal('lowest_price', 12, 2)->nullable();
            $table->decimal('max_price', 12, 2)->nullable();
            $table->string('property_thambnail');
            $table->text('short_descp')->nullable();
            $table->longText('long_descp')->nullable();
            $table->unsignedInteger('bedrooms')->nullable();
            $table->unsignedInteger('bathrooms')->nullable();
            $table->unsignedInteger('garage')->nullable();
            $table->unsignedInteger('garage_size')->nullable();
            $table->unsignedInteger('property_size')->nullable();
            $table->string('property_video')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('neighborhood')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('hot')->default(false);
            $table->integer('agent_id')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
