<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{HasMany, BelongsTo};


class InvoiceSundry extends Model
{
    //
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('InvoiceSundry');
    }
    protected $fillable = [
        'invoice_id',
        'bill_sundry_id',
        'amount_adjustment',
        'sundry_amount',
    ];
    protected $casts = [
        'sundry_amount' => 'decimal:2',
    ];


    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
    public function billSundry(): BelongsTo
    {
        return $this->belongsTo(BillSundry::class);
    }
}
