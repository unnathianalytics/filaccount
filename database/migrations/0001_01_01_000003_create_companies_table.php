<?php

use App\Models\Company;
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 55);
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('state_id')->constrained();
            $table->string('state_code')->nullable();
            $table->string('country')->nullable();
            $table->string('pincode')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('gstin')->nullable();
            $table->string('pan')->nullable();
            $table->string('cin')->nullable();
            $table->string('logo')->nullable();
            $table->string('currency')->default('INR');
            $table->string('currency_symbol')->default('₹');
            $table->string('current_financial_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
