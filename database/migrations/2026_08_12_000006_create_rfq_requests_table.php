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
        Schema::create('rfq_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('company_name');
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->integer('target_quantity');
            $table->decimal('target_unit_price', 12, 2);
            $table->date('delivery_deadline')->nullable();
            $table->text('packaging_specs')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'counter_offered'])->default('pending');
            $table->timestamps();

            $table->index(['product_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfq_requests');
    }
};
