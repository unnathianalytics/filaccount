<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Store extends Model
{
    //
    protected $fillable = [
        'branch_id',
        'name',
        'slug',
        'address',
        'city',
        'pin',
        'type',
        'field1',
        'field2',
        'field3',
        'field4',
        'field5',
        'field6',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
