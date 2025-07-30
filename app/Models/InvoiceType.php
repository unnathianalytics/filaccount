<?php

namespace App\Models;

use App\Models\Invoice;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceType extends Model
{
    //
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    protected $fillable = [
        'name',
        'slug',
        'print_title',
        'allowed_return_from',
        'in_out',
        'menu_order',
        'bg_color',
        'stock_value',
        'account_value',
        'transaction_category',
        'sn_input_type',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('InvoiceType');
    }
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
    public function invoice_print_configs(): HasMany
    {
        return $this->hasMany(InvoicePrintConfig::class);
    }
    public function getRouteKeyName(): string
    {
        return 'slug'; // or 'code' if you're using a different column
    }
}
