<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemGroup extends Model
{
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('ItemGroup');
    }
    protected $fillable = [
        'id',
        'name',
        'company_id',
        'primary_id',
        'user',
        'is_editable',
        'is_deletable',
    ];

    protected $casts = [
        'is_editable'  => 'boolean',
        'is_deletable' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ItemGroup::class, 'primary_id');
    }
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
