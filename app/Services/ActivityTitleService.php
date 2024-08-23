<?php

namespace App\Services;

use Carbon\Carbon;

class ActivityTitleService
{
    public static function getTitle(string $sport, Carbon $started_at, bool $stationary = false): string
    {
        switch($sport) {
            case 'cycling':
                $noun = 'Ride';
                break;

            case 'running':
                $noun = 'Run';
                break;

            case 'walking':
                $noun = 'Walk';
                break;

            default:
                $noun = 'Activity';
                break;
        }

        if ($stationary) {
            return 'Indoor ' . $noun;
        }

        $midnight = (int) $started_at->clone()->startOfDay()->format('U');
        $start = (int) $started_at->format('U');

        $diff = $start - $midnight;

        if ($diff < 18000 || $diff >= 75600) {
            return 'Night ' . $noun;
        }

        if ($diff >= 1800 && $diff < 43200) {
            return 'Morning ' . $noun;
        }

        if ($diff >= 43200 && $diff < 50400) {
            return 'Lunch ' . $noun;
        }

        if ($diff >= 50400 && $diff < 64800) {
            return 'Afternoon ' . $noun;
        }

        return 'Evening ' . $noun;
    }
}
