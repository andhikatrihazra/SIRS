<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{
    protected $primaryKey = 'license_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'license_number',
        'name',
        'specialization',
        'department_code'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_code', 'department_code');
    }

    public function doctorSchedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_license_number', 'license_number');
    }

    public function examinations(): HasMany
    {
        return $this->hasMany(Examination::class, 'doctor_license_number', 'license_number');
    }
}