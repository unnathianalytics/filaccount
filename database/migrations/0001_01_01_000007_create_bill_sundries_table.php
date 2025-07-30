<?php

use App\Models\BillSundry;
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
        Schema::create('bill_sundries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('adjustment', 1)->default('+')->comment('+ if the sundry is additive, - if it is subtractive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_sundries');
    }
};
