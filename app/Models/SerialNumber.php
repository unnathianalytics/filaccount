<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SerialNumber extends Model
{
    protected $fillable = ['item_id', 'serial_number', 'description', 'invoice_item_id', 'is_returned', 'last_outward_transaction_category', 'is_opening_stock'];
    protected $casts = [
        'is_opening_stock' => 'boolean',
        'is_returned' => 'boolean',
    ];
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function invoiceItem(): BelongsTo
    {
        return $this->belongsTo(InvoiceItem::class);
    }
    public function invoiceItemSerialNumbers(): HasMany
    {
        return $this->hasMany(InvoiceItemSerialNumber::class, 'serial_number_id');
    }
    public function latestInvoiceItemSerialNumber()
    {
        return $this->hasOne(InvoiceItemSerialNumber::class)->latest('id');
    }
}
