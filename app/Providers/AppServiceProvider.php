<?php

namespace App\Providers;

use App\Enums\PostStatus;
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
    }
}
