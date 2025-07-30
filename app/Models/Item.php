<?php

namespace App\Models;

use App\Models\Uom;
use App\Models\Unit;
use App\Models\ItemUom;
use App\Models\ItemGroup;
use App\Models\InvoiceItem;
use App\Models\InvoiceType;
use App\Models\TaxCategory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('Item');
    }
    protected $fillable = [
        'id',
        'group_id',
        'name',
        'barcode',
        'is_physical',
        'uom_id',
        'has_multi_uom',
        'has_serial_number',
        'op_stock_qty',
        'op_stock_amount',
        'tax_category_id',
        'hsn_sac',
        'sale_price',
        'purchase_price',
        'max_retail_price',
        'min_sale_price',
        'self_val_price',
        'description1',
        'description2',
        'description3',
        'description4',
        'description5',
        'min_level_qty',
        'reorder_level_qty',
        'max_level_qty',
        'user',
    ];

    protected $casts = [
        'is_physical' => 'boolean',
        'has_multi_uom' => 'boolean',
        'has_serial_number' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ItemGroup::class, 'group_id');
    }
    public function taxCategory(): BelongsTo
    {
        return $this->belongsTo(TaxCategory::class, 'tax_category_id');
    }
    public function baseUom()
    {
        return $this->belongsTo(Uom::class, 'uom_id');
    }
    public function uoms()
    {
        return $this->hasMany(ItemUom::class, 'item_id');
    }
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function getStock(): float
    {
        $inwardQty = $this->invoiceItems()
            ->whereHas('invoice.invoiceType', function ($q) {
                $q->where('stock_value', '+');
            })
            ->sum('quantity');

        $outwardQty = $this->invoiceItems()
            ->whereHas('invoice.invoiceType', function ($q) {
                $q->where('stock_value', '-');
            })
            ->sum('quantity');

        return $this->op_stock_qty + $inwardQty - $outwardQty;
    }
    public function getOpeningStock()
    {
        return SerialNumber::where('item_id', $this->id)->whereNull('invoice_item_id')->count();
    }
}
