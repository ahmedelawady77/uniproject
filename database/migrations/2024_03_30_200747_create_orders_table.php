<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userapp_id')->references('id')->on('userapps')->onDelete('cascade');
            $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->decimal('order_total', 10, 2);
            $table->enum('status',['pending','Deliverd','Canceled'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
