<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Examination extends Model
{
    protected $primaryKey = 'examination_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'examination_code',
        'registration_code',
        'doctor_license_number',
        'diagnosis',
        'notes'
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_code', 'registration_code');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_license_number', 'license_number');
    }

    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class, 'examination_code', 'examination_code');
    }
}