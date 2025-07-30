<?php

use App\Models\Item;
use Database\Seeders\ItemSeeder;
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('item_groups')->cascadeOnDelete();
            $table->string('name', 55);
            $table->string('barcode', 55)->nullable();

            $table->foreignId('uom_id')->constrained('uoms');
            $table->boolean('has_multi_uom')->default(false);
            $table->boolean('has_serial_number')->default(false);


            $table->boolean('is_physical')->default(true)->comment('Physical/Service: default Phhysical');
            $table->decimal('op_stock_qty')->default('0.00');
            $table->decimal('op_stock_amount')->default('0.00');
            $table->foreignId('tax_category_id');
            $table->string('hsn_sac', 8)->nullable();

            $table->decimal('sale_price')->default('0.00');
            $table->decimal('purchase_price')->default('0.00');
            $table->decimal('max_retail_price')->default('0.00');
            $table->decimal('min_sale_price')->default('0.00');
            $table->decimal('self_val_price')->default('0.00');

            $table->tinyText('description1')->nullable();
            $table->tinyText('description2')->nullable();
            $table->tinyText('description3')->nullable();
            $table->tinyText('description4')->nullable();
            $table->tinyText('description5')->nullable();

            $table->decimal('min_level_qty')->default(0);
            $table->decimal('reorder_level_qty')->default(0);
            $table->decimal('max_level_qty')->default(0);
            $table->foreignId('user')->default(1);
            $table->timestamps();

            $table->foreign('uom_id')->references('id')->on('uoms')->onDelete('cascade');
            $table->foreign('tax_category_id')->references('id')->on('tax_categories')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('item_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
