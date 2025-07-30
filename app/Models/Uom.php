<?php

namespace App\Models;

use App\Models\Item;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Uom extends Model
{
    //
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()
            ->logAll()
            ->useLogName('Uom');
    }

    protected $fillable = [
        'id',
        'name',
        'uqc',
        'deletable',
    ];
    protected $casts = [
        'deletable' => 'boolean',
    ];

    public function baseUom()
    {
        return $this->belongsTo(Uom::class, 'uom_id');
    }

    public function uoms()
    {
        return $this->hasMany(ItemUom::class);
    }
}
