<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $primaryKey = 'department_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'department_code',
        'name',
        'location'
    ];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'department_code', 'department_code');
    }

    public function doctorSchedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class, 'department_code', 'department_code');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'department_code', 'department_code');
    }
}