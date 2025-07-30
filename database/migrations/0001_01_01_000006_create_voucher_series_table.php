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
        Schema::create('voucher_series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_type_id')->constrained('invoice_types');
            $table->string('name')->nullable();
            $table->enum('vn_type', ['manual', 'automatic'])->default('automatic');
            $table->string('vn_prefix')->nullable();
            $table->string('vn_sep_1')->nullable();
            $table->string('vn_from')->nullable();
            $table->string('vn_sep_2')->nullable();
            $table->string('vn_sufix')->nullable();
            $table->foreignId(column: 'branch_id')->constrained('branches');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_series');
    }
};
