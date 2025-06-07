<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prescription extends Model
{
    protected $primaryKey = 'prescription_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['prescription_code', 'examination_code', 'instructions'];

    public function examination(): BelongsTo
    {
        return $this->belongsTo(Examination::class, 'examination_code', 'examination_code');
    }

    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'prescription_medicines')
            ->withPivot('quantity', 'dosage')
            ->withTimestamps();
    }

    public function prescriptionMedicines()
    {
        return $this->hasMany(PrescriptionMedicine::class, 'prescription_code', 'prescription_code');
    }
}
