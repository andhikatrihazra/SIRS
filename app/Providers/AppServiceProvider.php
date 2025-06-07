<?php

namespace App\Providers;

use App\Models\Prescription;
use App\Models\InpatientCare;
use App\Models\PrescriptionMedicine;
use App\Observers\PrescriptionObserver;
use Illuminate\Support\ServiceProvider;
use App\Observers\InpatientCareObserver;
use App\Observers\PrescriptionMedicineObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        PrescriptionMedicine::observe(PrescriptionMedicineObserver::class);
            Prescription::observe(PrescriptionObserver::class);
                InpatientCare::observe(InpatientCareObserver::class);


    }
}
