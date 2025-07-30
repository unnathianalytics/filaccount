<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Account extends Model
{
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('Account');
    }

    protected $fillable = [
        'group_id',
        'name',
        'address',
        'mobile',
        'email',
        'is_registered',
        'state_id',
        'gstin',
        'cr_dr',
        'op_balance',
        'is_editable',
        'is_deletable',
        'image',
        'user',
    ];
    protected $casts = [
        'is_registered' => 'boolean',
        'is_editable'  => 'boolean',
        'is_deletable' => 'boolean',
        'image'        => 'array',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(AccountGroup::class, 'group_id');
    }
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
    public function scopeInvoiceAccounts($query)
    {
        $accountGroupsToInclude = [12, 16, 20];
        return $query->whereIn('group_id', $accountGroupsToInclude)
            ->orWhereHas('parent', function ($query) use ($accountGroupsToInclude) {
                $query->whereIn('primary_id', $accountGroupsToInclude);
            });
    }
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
    public function acc_debit_accounts(): HasMany
    {
        return $this->hasMany(AccountingVoucherItem::class, 'dr_account_id');
    }
    public function acc_credit_accounts(): HasMany
    {
        return $this->hasMany(AccountingVoucherItem::class, 'cr_account_id');
    }

    public function voucherDebitAmount($asOn = null): float
    {
        $total_debit_amount = 0;
        $query = $this->acc_debit_accounts();
        if ($asOn) {
            $query->whereHas('accountingVoucher', function ($q) use ($asOn) {
                $q->where('transaction_date', '<=', $asOn);
            });
        }
        $debit_items = $query->get();
        foreach ($debit_items as $item) {
            $total_debit_amount += $item->dr_amount;
        }
        return $total_debit_amount;
    }

    public function voucherCreditAmount($asOn = null): float
    {
        $total_credit_amount = 0;
        $query = $this->acc_credit_accounts();
        if ($asOn) {
            $query->whereHas('accountingVoucher', function ($q) use ($asOn) {
                $q->where('transaction_date', '<=', $asOn);
            });
        }
        $credit_items = $query->get();
        foreach ($credit_items as $item) {
            $total_credit_amount -= $item->cr_amount;
        }
        return $total_credit_amount;
    }


    public function get_cb($asOn, $toPreviousDate = true)
    {
        if ($toPreviousDate) {
            $asOn = date('Y-m-d', strtotime("$asOn -1 day"));
        }

        $initial_balance = ($this->op_balance * ($this->cr_dr == 'cr' ? 1 : -1)) ?? 0;
        $total_invoice_amount = 0;

        //invoices
        DB::enableQueryLog();
        $invoices = $this->invoices()->where('invoice_date', '<=', $asOn)->get();
        // dd(DB::getQueryLog());

        foreach ($invoices as $invoice) {
            if ($invoice->invoiceType->account_value === 'cr') {
                $total_invoice_amount -= $invoice->getInvoiceTotal($invoice->id);
            } elseif ($invoice->invoiceType->account_value === 'dr') {
                $total_invoice_amount += $invoice->getInvoiceTotal($invoice->id);
            }
        }
        //voucher debit and credit amounts
        $voucherDebitAmount = $this->voucherDebitAmount($asOn);
        $voucherCreditAmount = $this->voucherCreditAmount($asOn);

        $balace = $initial_balance + $total_invoice_amount + $voucherCreditAmount + $voucherDebitAmount;
        return formatAmountWithDrCr($balace);
    }
}
