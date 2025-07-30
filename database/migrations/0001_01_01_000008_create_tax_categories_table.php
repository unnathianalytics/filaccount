7
<?php

use App\Models\TaxCategory;
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
        Schema::create('tax_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 55);
            $table->decimal('igst_pct', 2, 2);
            $table->decimal('cgst_pct', 2, 2);
            $table->decimal('sgst_pct', 2, 2);
            $table->decimal('cess_pct', 2, 2)->default(0);
            $table->foreignId('user')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_categories');
    }
};
