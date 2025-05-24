<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable(); // e.g., ultrasonic, infrared
            $table->string('status')->default('active'); // active, inactive
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('mac_address')->unique()->nullable();
            $table->string('api_token')->nullable(); // For device authentication
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};