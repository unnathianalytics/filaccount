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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('store_id')->constrained('stores');
            $table->boolean('countable')->default(true);
            $table->date('stock_update_date')->nullable();
            $table->foreignId('item_id')->constrained('items');

            $table->string('item_description1')->nullable();
            $table->string('item_description2')->nullable();
            $table->string('item_description3')->nullable();
            $table->string('item_description4')->nullable();

            $table->foreignId('uom_id');
            $table->decimal('quantity');
            $table->decimal('base_quantity');

            $table->string('batch_no')->nullable();
            $table->string('batch_exp')->nullable();
            $table->string('hsn_sac')->nullable();
            $table->decimal('max_retail_price')->default('0.00');
            $table->decimal('price')->default('0.00');
            $table->foreignId('tax_category_id');
            $table->decimal('igst_pct')->default(0);
            $table->decimal('cgst_pct')->default(0);
            $table->decimal('sgst_pct')->default(0);
            $table->decimal('cess_pct')->default(0);

            $table->decimal('igst_amt')->default(0);
            $table->decimal('cgst_amt')->default(0);
            $table->decimal('sgst_amt')->default(0);
            $table->decimal('cess_amt')->default(0);

            $table->decimal('discount_pct')->default(0);
            $table->decimal('discount_amt')->default(0);
            $table->decimal('taxable_amt')->default(0);
            $table->decimal('item_amount', 10, 2)->default(0);
            $table->foreignId('user')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
