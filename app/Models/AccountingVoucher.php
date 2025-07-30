<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AccountingVoucher extends Model
{
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('AccountVoucher');
    }
    protected $fillable = [
        'financial_year_id',
        'voucher_series_id',
        'transaction_date',
        'transaction_time',
        'voucher_number',
        'accounting_type_id',
        'voucher_notes',
        'user',
    ];
    public function financialYear(): BelongsTo
    {
        return $this->belongsTo(FinancialYear::class, 'financial_year_id');
    }
    public function accountingType(): BelongsTo
    {
        return $this->belongsTo(AccountingType::class);
    }
    public function accountingVoucherItems()
    {
        return $this->hasMany(AccountingVoucherItem::class, 'accounting_voucher_id');
    }

    public function debit_items_amount()
    {
        return $this->accountingVoucherItems()->where('cr_dr', 'dr')->sum('amount');
    }

    public function credit_items_amount()
    {
        return $this->accountingVoucherItems()->where('cr_dr', 'cr')->sum('amount');
    }
}
