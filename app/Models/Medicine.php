<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    protected $primaryKey = 'medicine_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'medicine_code',
        'name',
        'type',
        'description',
        'stock'
    ];

    public function prescriptions(): BelongsToMany
    {
        return $this->belongsToMany(Prescription::class, 'prescription_medicines', 'medicine_code', 'prescription_code')
            ->withPivot('quantity', 'dosage')
            ->withTimestamps();
    }

    public function prescriptionMedicines(): HasMany
    {
        return $this->hasMany(PrescriptionMedicine::class, 'medicine_code', 'medicine_code');
    }
}