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
        Schema::create('invoice_print_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_type_id')->constrained('invoice_types');
            $table->string('name')->nullable();
            $table->string('print_title')->nullable();
            $table->string('declaration1')->nullable();
            $table->string('declaration2')->nullable();
            $table->string('declaration3')->nullable();
            $table->string('declaration4')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_ifsc_code')->nullable();
            $table->string('bank_upi_id')->nullable();
            $table->string('terms_conditions1')->nullable();
            $table->string('terms_conditions2')->nullable();
            $table->string('terms_conditions3')->nullable();
            $table->string('terms_conditions4')->nullable();
            $table->string('terms_conditions5')->nullable();
            $table->string('terms_conditions6')->nullable();
            $table->string('signatory_information1')->nullable();
            $table->string('signatory_information2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_print_configs');
    }
};
