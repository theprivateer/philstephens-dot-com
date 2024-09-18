<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Activity;
use App\Enums\PostStatus;
use App\Enums\Sports;
use App\Models\Album;
use App\Observers\BookObserver;
use App\Observers\ActivityObserver;
use App\Observers\AlbumObserver;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Activity::observe(ActivityObserver::class);
        Book::observe(BookObserver::class);
        Album::observe(AlbumObserver::class);

        TextColumn::macro('postStatus', function () {
            $this
                ->badge()
                ->color(static function ($state): string {
                    if ($state === PostStatus::PUBLISHED) {
                        return 'success';
                    } elseif ($state === PostStatus::SCHEDULED) {
                        return 'warning';
                    }
                    return 'gray';
                })
                ->formatStateUsing(fn (PostStatus $state): string => strtoupper($state->value));

            return $this;
        });

        TextColumn::macro('sport', function () {
            $this
                ->badge()
                ->color(static function ($state): string {
                    if ($state === Sports::CYCLING) {
                        return 'success';
                    } elseif ($state === Sports::RUNNING) {
                        return 'warning';
                    } elseif ($state === Sports::WALKING) {
                        return 'danger';
                    }  elseif ($state === Sports::SWIMMING) {
                        return 'info';
                    }
                    return 'gray';
                })
                ->formatStateUsing(fn (Sports $state): string => strtoupper($state->value));

            return $this;
        });
    }
}
