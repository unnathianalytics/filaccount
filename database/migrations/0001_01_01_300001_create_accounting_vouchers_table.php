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
        Schema::create('accounting_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_year_id')->constrained('financial_years');
            $table->foreignId('voucher_series_id')->constrained('voucher_series')->onDelete('cascade')->default(1);
            $table->string('accounting_type_id');
            $table->date('transaction_date');
            $table->time('transaction_time');
            $table->string('voucher_number');
            $table->string('voucher_notes')->nullable();
            $table->foreignId('user')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting_vouchers');
    }
};
