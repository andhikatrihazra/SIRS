<?php

namespace App\Observers;

use App\Models\Prescription;

class PrescriptionObserver
{
    public function deleting(Prescription $prescription)
    {
        // Hapus anak satu per satu supaya observer PrescriptionMedicine jalan
        $prescription->prescriptionMedicines->each->delete();
    }
}
