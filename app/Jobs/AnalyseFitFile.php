<?php

namespace App\Jobs;

use App\Enums\Sports;
use Polyline;
use App\Models\Activity;
use Glhd\Linen\CsvReader;
use App\Models\ActivityPoint;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Privateer\FIT\phpFITFileAnalysis;
use App\Services\ActivityTitleService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AnalyseFitFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Activity $activity
        )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // ActivityPoint::where('activity_id', $this->activity->id)->delete();
        // $stravaActivities =

        $options = ['fix_data' => ['all']];

        $pFFA = new phpFITFileAnalysis(storage_path('app/public/' . $this->activity->file), $options);

        $timezone = $this->getHistoricActivityTimezone($pFFA->data_mesgs['session']['start_time']);

        $activity_data = [
            'sport' => strtolower($pFFA->sport()),
            'timezone' =>  $timezone,
            'started_at' => Carbon::createFromTimestamp($pFFA->data_mesgs['session']['start_time'])->setTimezone($timezone),
            'total_elapsed_time' => $pFFA->data_mesgs['session']['total_elapsed_time'],
            'total_timer_time' => $pFFA->data_mesgs['session']['total_timer_time'],
            'avg_speed' => $pFFA->data_mesgs['session']['avg_speed'] ?? null,
            'max_speed' => $pFFA->data_mesgs['session']['max_speed'] ?? null,
            'total_distance' => $pFFA->data_mesgs['session']['total_distance'],
            'avg_cadence' => $pFFA->data_mesgs['session']['avg_cadence'] ?? null,
            'max_cadence' => $pFFA->data_mesgs['session']['max_cadence'] ?? null,
            'avg_heart_rate' => $pFFA->data_mesgs['session']['avg_heart_rate'] ?? null,
            'max_heart_rate' => $pFFA->data_mesgs['session']['max_heart_rate'] ?? null,
            'avg_power' => $pFFA->data_mesgs['session']['avg_power'] ?? null,
            'max_power' => $pFFA->data_mesgs['session']['max_power'] ?? null,
            'total_calories' => $pFFA->data_mesgs['session']['total_calories'],
            'total_ascent_device' => $pFFA->data_mesgs['session']['total_ascent'] ?? null,
            'stationary' => false,
        ];

        $this->activity->update($activity_data);

        $latLongPoints = [];

        foreach ($pFFA->data_mesgs['record']['timestamp'] as $t) {
            // $point = ActivityPoint::where('activity_id', $this->activity->id)->where('timestamp', $t)->first();

            // if (! $point) {
            //     $point = new ActivityPoint([
            //         'activity_id' => $this->activity->id,
            //         'timestamp' => $t,
            //     ]);
            // }

            // $point->fill([
            //     'position_lat' => $pFFA->data_mesgs['record']['position_lat'][$t] ?? null,
            //     'position_long' => $pFFA->data_mesgs['record']['position_long'][$t] ?? null,
            //     'heart_rate' => $pFFA->data_mesgs['record']['heart_rate'][$t] ?? null,
            //     'cadence' => $pFFA->data_mesgs['record']['cadence'][$t] ?? null,
            //     'speed' => $pFFA->data_mesgs['record']['speed'][$t] ?? null,
            //     'altitude_device' => isset($pFFA->data_mesgs['record']['altitude'][$t]) ? $pFFA->data_mesgs['record']['altitude'][$t] : null,
            //     'power' => $pFFA->data_mesgs['record']['power'][$t] ?? null,
            //     'cumulative_distance' => $pFFA->data_mesgs['record']['distance'][$t],
            // ]);

            // $point->save();

            if (! empty($pFFA->data_mesgs['record']['position_lat'][$t] ?? null) &&
            ! empty($pFFA->data_mesgs['record']['position_long'][$t] ?? null)) {
                $latLongPoints[] = [
                    $pFFA->data_mesgs['record']['position_lat'][$t],
                    $pFFA->data_mesgs['record']['position_long'][$t]
                ];
            }
        }

        if (count($latLongPoints) > 0) {
            $encoded = Polyline::encode($latLongPoints);

            $this->activity->update([
                'polyline' => $encoded
            ]);
        } elseif ($this->activity->fresh()->sport != Sports::SWIMMING) {
            $this->activity->update([
                'stationary' => true,
            ]);
        }

        $strava = CsvReader::from(storage_path('app/rsync/activities/activities.csv'))
                        ->collect()
                        ->keyBy('filename')
                        ->toArray();

        if (isset($strava[$this->activity->file . '.gz'])) {
            $title = $strava[$this->activity->file . '.gz']['activity_name'];
            $content = $strava[$this->activity->file . '.gz']['activity_description'];
            $tags = ['Strava'];
        } else {
            $title = $this->activity->title ?: ActivityTitleService::getTitle(
                $activity_data['sport'],
                $activity_data['started_at'],
                $this->activity->stationary ?? false
            );

            if (strpos($this->activity->file, 'ELEMNT') !== false ||
                strpos($this->activity->file, 'FITNESS') !== false ||
                strpos($this->activity->file, 'WAHOO') !== false) {
                $tags = ['Wahoo'];
            }
        }

        $this->activity->update([
            'title' => $title,
            'content' => $this->activity->content ?: $content ?? null,
            'tags' => $this->activity->tags ?: $tags ?? null,
            'processed_at' => now(),
        ]);
    }

    private function getHistoricActivityTimezone($start_string)
    {
        if ($this->activity->timezone) {
            return $this->activity->timezone;
        }

        $start = Carbon::createFromTimestamp($start_string);

        if ($start->lt(Carbon::parse('2013-05-01'))) {
            return 'Europe/London';
        }

        if ($start->lt(Carbon::parse('2013-08-01'))) {
            return 'Pacific/Auckland';
        }

        return config('app.timezone');
    }
}
