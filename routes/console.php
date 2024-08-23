<?php

use App\Models\Activity;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('sync-fit', function () {
    $files = Storage::disk('public')->files('activities');

    collect($files)->each(function ($file) {
        if (! $exists = Activity::where('file', $file)->first()) {
            Activity::create([
                'file' => $file,
            ]);
        }
    });
});

Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');
