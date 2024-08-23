<?php

namespace App\Observers;

use App\Jobs\AnalyseFitFile;
use App\Models\Activity;

class ActivityObserver
{
    /**
     * Handle the Activity "created" event.
     */
    public function created(Activity $activity): void
    {
        if ($activity->file) {
            AnalyseFitFile::dispatch(activity: $activity);
        }
    }
}
