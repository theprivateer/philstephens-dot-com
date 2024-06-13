<?php

namespace App\Models;

use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model implements Feedable
{
    use HasFactory;
    use HasSlug;

    protected $guarded = [];

    public function scopePublished(Builder $query): void
    {
        $query->where(function ($query) {
            $query->whereNotNull('published_at')
                ->where('published_at', '<=', now());
        })->orderBy('published_at', 'desc');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary(
                'By ' . $this->artist . " ({$this->released})\n" .
                'Listen: ' . $this->listen_link
            )
            ->updated($this->updated_at)
            ->link(route('album.show', $this->slug))
            ->authorName('Phil Stephens')
            ->authorEmail('phils@hey.com');
    }

    public static function getFeedItems()
    {
        return Album::published()->get();
    }
}
