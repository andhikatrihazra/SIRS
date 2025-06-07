<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InpatientCare extends Model
{
    protected $fillable = [
        'patient_medical_record_number',
        'room_code',
        'admission_date',
        'discharge_date'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_medical_record_number', 'medical_record_number');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_code', 'room_code');
    }
}