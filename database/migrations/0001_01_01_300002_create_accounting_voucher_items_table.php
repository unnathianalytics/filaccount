<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounting_voucher_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_voucher_id')->constrained('accounting_vouchers')->onDelete('cascade');

            $table->enum('avr_item_type', ['cr', 'dr']);
            $table->foreignId('cr_account_id');
            $table->decimal('cr_amount', 15, 2);
            $table->foreignId('dr_account_id');
            $table->decimal('dr_amount', 15, 2);
            $table->string('description')->nullable();
            $table->foreignId('user')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting_voucher_items');
    }
};
