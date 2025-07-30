<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountingType extends Model
{
    //
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    protected $fillable = [
        'name',
        'slug',
        'bg_color',
        'acc_value',
        'order',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('AccountingType');
    }
    public function accountingVouchers(): HasMany
    {
        return $this->hasMany(AccountingVoucher::class);
    }
    public function getRouteKeyName(): string
    {
        return 'slug'; // or 'code' if you're using a different column
    }
}
