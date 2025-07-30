<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('InvoiceItem');
    }
    protected $fillable = [
        'countable',
        'invoice_id',
        'stock_update_date',
        'item_id',
        'item_description1',
        'item_description2',
        'item_description3',
        'item_description4',
        'store_id',
        'uom_id',
        'quantity',
        'base_quantity',
        'hsn_sac',
        'batch_no',
        'batch_exp',
        'max_retail_price',
        'price',
        'tax_category_id',
        'igst_pct',
        'cgst_pct',
        'sgst_pct',
        'cess_pct',
        'igst_amt',
        'cgst_amt',
        'sgst_amt',
        'cess_amt',
        'discount_pct',
        'discount_amt',
        'taxable_amt',
        'item_amount',
        'user',
    ];

    protected $casts = [
        'sale_price' => 'decimal:2',
        'max_retail_price' => 'decimal:2',
        'price' => 'decimal:2',
        'cgst_amt' => 'decimal:2',
        'sgst_amt' => 'decimal:2',
        'cess_amt' => 'decimal:2',
        'discount_amt' => 'decimal:2',
        'taxable_amt' => 'decimal:2',
        'item_amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function serial_numbers()
    {
        return $this->hasMany(InvoiceItemSerialNumber::class, 'invoice_item_id');
    }

    public function serialNumbers()
    {
        return $this->hasMany(SerialNumber::class, 'invoice_item_id');
    }

    public function invoiceItemSerialNumbers()
    {
        return $this->hasMany(InvoiceItemSerialNumber::class, 'invoice_item_id');
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id');
    }
    public function scopeCountable($query)
    {
        return $query->where('countable', '=', true);
    }
}
