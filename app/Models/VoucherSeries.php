<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoucherSeries extends Model
{
    //
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('VoucherSeries');
    }
    protected $fillable = [
        'name',
        'branch_id',
        'invoice_type_id',
        'vn_type',
        'vn_prefix',
        'vn_sep_1',
        'vn_from',
        'vn_sep_2',
        'vn_sufix',
        'status',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function invoice_type(): BelongsTo
    {
        return $this->belongsTo(InvoiceType::class, 'invoice_type_id');
    }
}
