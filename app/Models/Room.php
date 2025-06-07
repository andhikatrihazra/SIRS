<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $primaryKey = 'room_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'room_code',
        'name',
        'type',
        'capacity'
    ];

    public function inpatientCares(): HasMany
    {
        return $this->hasMany(InpatientCare::class, 'room_code', 'room_code');
    }
}