<?php

use App\Models\Activity;
use App\Jobs\AnalyseFitFile;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('reprocess-activities', function () {
    Activity::get()->each(function ($activity) {
        if ($activity->file) {
            AnalyseFitFile::dispatch(activity: $activity);
        }
    });
});

Artisan::command('fit:sync', function () {
    $files = Storage::disk('public')->files('activities');

    collect($files)->each(function ($file) {
        $parts = explode('.', $file);
        $extension = array_pop($parts);

        if ($extension != 'fit') {
            return;
        }

        if (! $exists = Activity::where('file', $file)->first()) {
            Activity::create([
                'file' => $file,
            ]);
        }
    });
})->daily();

Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');
