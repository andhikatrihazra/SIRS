<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected $primaryKey = 'registration_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'registration_code',
        'patient_medical_record_number',
        'department_code',
        'status',
        'examination_date',
        'notes',
        'registration_date'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_medical_record_number', 'medical_record_number');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_code', 'department_code');
    }

    public function examinations(): HasMany
    {
        return $this->hasMany(Examination::class, 'registration_code', 'registration_code');
    }
}