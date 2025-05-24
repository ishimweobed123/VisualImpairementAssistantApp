<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obstacles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->onDelete('cascade');
            $table->float('distance')->nullable(); // Distance to obstacle (meters)
            $table->string('type')->nullable(); // e.g., wall, object
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamp('detected_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obstacles');
    }
};