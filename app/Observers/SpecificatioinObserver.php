<?php

namespace App\Observers;

use App\Models\Specification;

class SpecificatioinObserver
{
    /**
     * Handle the Specification "created" event.
     */
    public function created(Specification $specification): void
    {
        //
    }

    /**
     * Handle the Specification "updated" event.
     */
    public function updated(Specification $specification): void
    {
        //
    }

    /**
     * Handle the Specification "deleted" event.
     */
    public function deleted(Specification $specification): void
    {
        //
    }

    /**
     * Handle the Specification "restored" event.
     */
    public function restored(Specification $specification): void
    {
        //
    }

    /**
     * Handle the Specification "force deleted" event.
     */
    public function forceDeleted(Specification $specification): void
    {

    }

    public function deleting(Specification $specification)
    {
        
    }
}
