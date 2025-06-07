<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $primaryKey = 'medical_record_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'medical_record_number',
        'name',
        'gender',
        'birthdate',
        'address',
        'phone'
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'patient_medical_record_number', 'medical_record_number');
    }

    public function inpatientCares(): HasMany
    {
        return $this->hasMany(InpatientCare::class, 'patient_medical_record_number', 'medical_record_number');
    }
}