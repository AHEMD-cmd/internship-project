<?php

namespace App\Observers;

use App\Models\Place;
use Illuminate\Support\Facades\Storage;

class PlaceObserver
{
    /**
     * Handle the Place "created" event.
     */
    public function created(Place $place): void
    {
        //
    }

    /**
     * Handle the Place "updated" event.
     */
    public function updated(Place $place): void
    {
        //
    }

    /**
     * Handle the Place "deleted" event.
     */
    public function deleted(Place $place): void
    {
        //
    }

    /**
     * Handle the Place "restored" event.
     */
    public function restored(Place $place): void
    {
        //
    }

    /**
     * Handle the Place "force deleted" event.
     */
    public function forceDeleted(Place $place): void
    {
        //
    }

    public function deleting(Place $place)
    {

    }
}
