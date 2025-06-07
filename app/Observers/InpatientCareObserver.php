<?php

namespace App\Observers;

use App\Models\InpatientCare;

class InpatientCareObserver
{
    public function created(InpatientCare $inpatientCare)
    {
        $room = $inpatientCare->room;
        if ($room) {
            // Kurangi capacity (misal capacity = kamar yang tersisa)
            $room->decrement('capacity');
        }
    }

    public function deleted(InpatientCare $inpatientCare)
    {
        $room = $inpatientCare->room;
        if ($room) {
            // Tambah capacity karena pasien keluar
            $room->increment('capacity');
        }
    }
}
