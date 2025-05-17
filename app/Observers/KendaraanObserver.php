<?php

namespace App\Observers;

use Illuminate\Support\Facades\Log;
use App\Models\Kendaraan;
use App\Events\DashboardUpdated;

class KendaraanObserver
{
    /**
     * Handle the Kendaraan "created" event.
     */
    public function created(Kendaraan $kendaraan): void
    {
        Log::info('Observer dipanggil: product updated');
        broadcast(new DashboardUpdated($kendaraan, 'updated'))->toOthers();
    }

    /**
     * Handle the Kendaraan "updated" event.
     */
    public function updated(Kendaraan $kendaraan): void
    {
        Log::info('Observer dipanggil: product updated');
        broadcast(new DashboardUpdated($kendaraan, 'updated'))->toOthers();
    }

    /**
     * Handle the Kendaraan "deleted" event.
     */
    public function deleted(Kendaraan $kendaraan): void
    {
        //
    }

    /**
     * Handle the Kendaraan "restored" event.
     */
    public function restored(Kendaraan $kendaraan): void
    {
        //
    }

    /**
     * Handle the Kendaraan "force deleted" event.
     */
    public function forceDeleted(Kendaraan $kendaraan): void
    {
        //
    }
}
