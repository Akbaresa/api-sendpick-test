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
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id('id_job_order');
            $table->string('job_number')->unique();
            $table->string('customer_name');
            $table->text('pickup_address');
            $table->text('destination_address');
            $table->foreignId('status_job_order_id')->constrained('status_job_orders', 'id_status_job_order');
            $table->foreignId('driver_id')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles', 'id_vehicle')->nullOnDelete();
            $table->float('total_weight')->nullable();
            $table->float('total_volume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_orders');
    }
};
