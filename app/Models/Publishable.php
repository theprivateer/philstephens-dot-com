<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Builder;


trait Publishable
{
    public function scopePublished(Builder $query): void
    {
        $query->where(function ($query) {
            $query->whereNotNull('published_at')
                ->where('published_at', '<=', now());
        })->orderBy('published_at', 'desc');
    }

    public function getStatusAttribute(): PostStatus
    {
        if (empty($this->getAttribute('published_at'))) {
            return PostStatus::DRAFT;
        }

        if ($this->getAttribute('published_at')->gt(now())) {
            return PostStatus::SCHEDULED;
        }

        return PostStatus::PUBLISHED;
    }
}
