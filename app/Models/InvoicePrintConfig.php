<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoicePrintConfig extends Model
{
    //
    protected $fillable = [
        'invoice_type_id',
        'name',
        'print_title',
        'declaration1',
        'declaration2',
        'declaration3',
        'declaration4',
        'bank_name',
        'bank_account_number',
        'bank_ifsc_code',
        'bank_upi_id',
        'terms_conditions1',
        'terms_conditions2',
        'terms_conditions3',
        'terms_conditions4',
        'terms_conditions5',
        'terms_conditions6',
        'signatory_information1',
        'signatory_information2',
    ];

    public function invoice_type(): BelongsTo
    {
        return $this->belongsTo(InvoiceType::class, 'invoice_type_id');
    }
}
