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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_year_id')->constrained('financial_years');
            $table->foreignId('voucher_series_id')->constrained('voucher_series')->cascadeOnDelete();
            $table->foreignId('invoice_type_id')->constrained('invoice_types');
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('destination_store_id')->nullable();
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->foreignId('tax_type_id');
            $table->time('invoice_time')->nullable();
            $table->foreignId('account_id');
            $table->string('description')->nullable();
            $table->date('einvoice_ack_date')->nullable();
            $table->string('einvoice_ack_no')->nullable();
            $table->string('einvoice_irn')->nullable();
            $table->string('einvoice_qrcode')->nullable();
            $table->string('einvoice_qrcode_ksa')->nullable();
            $table->boolean('einvoice_required')->default(false);
            $table->date('eway_bill_date_gst')->nullable();
            $table->string('eway_bill_no_gst')->nullable();
            $table->boolean('eway_bill_required')->default(false);
            $table->foreignId('user')->default(1);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
