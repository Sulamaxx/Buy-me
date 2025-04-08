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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->double('value')->nullable();
            $table->string('value_type')->nullable(); // e.g., 'percentage' or 'fixed'
            $table->dateTime('valid_period')->nullable();
            $table->string('utilized')->nullable(); // e.g., 'yes' or 'no' or user info
            $table->dateTime('utilized_date')->nullable();
            $table->string('status')->nullable(); // e.g., 'active', 'expired'
            $table->boolean('is_active')->nullable()->default(true);
            $table->unsignedBigInteger('user_id')->nullable();

            // Foreign key constraint
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
