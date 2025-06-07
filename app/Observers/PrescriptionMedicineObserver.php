<?php

namespace App\Observers;

use App\Models\Medicine;
use App\Models\PrescriptionMedicine;

class PrescriptionMedicineObserver
{
    /**
     * Handle the PrescriptionMedicine "created" event.
     */
    public function created(PrescriptionMedicine $prescriptionMedicine): void
    {
        $medicine = Medicine::find($prescriptionMedicine->medicine_code);
        if ($medicine) {
            $medicine->decrement('stock', $prescriptionMedicine->quantity);
        }
    }

    /**
     * Handle the PrescriptionMedicine "updated" event.
     */
    public function updated(PrescriptionMedicine $prescriptionMedicine): void
    {
        //
    }


    public function deleted(PrescriptionMedicine $prescriptionMedicine): void
    {
        $medicine = Medicine::find($prescriptionMedicine->medicine_code);
        if ($medicine) {
            $medicine->increment('stock', $prescriptionMedicine->quantity);
        }
    }



}
