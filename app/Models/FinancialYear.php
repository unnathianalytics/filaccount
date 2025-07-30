<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    //
    protected $fillable = ['company_id', 'name', 'start_date', 'end_date', 'is_active'];
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'financial_year_id');
    }
    public function accountingVouchers()
    {
        return $this->hasMany(AccountingVoucher::class, 'financial_year_id');
    }
}
