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
        Schema::create('invoice_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('print_title');
            $table->enum('in_out', ['inward', 'outward', 'transfer', 'none']);
            $table->enum('transaction_category', ['material', 'sale', 'purchase', 'return', 'transfer', 'other'])->default('other');
            $table->bigInteger('allowed_return_from')->nullable();
            $table->string('bg_color');
            $table->string('stock_value', 1)->nullable();
            $table->string('account_value', 1)->nullable();
            $table->enum('sn_input_type', ['input', 'select', 'none'])->default('none');
            $table->smallInteger('menu_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_types');
    }
};
