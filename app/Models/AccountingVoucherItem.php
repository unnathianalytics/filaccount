<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountingVoucherItem extends Model
{
    //
    use HasFactory, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('AccountingType');
    }
    protected $fillable = [
        'accounting_voucher_id',
        'avr_item_type',
        'cr_account_id',
        'cr_amount',
        'dr_account_id',
        'dr_amount',
        'description',
        'user'
    ];

    public function accountingVoucher()
    {
        return $this->belongsTo(AccountingVoucher::class, 'accounting_voucher_id');
    }

    public function debit_acc(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'dr_account_id');
    }
    public function credit_acc(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'cr_account_id');
    }
}
