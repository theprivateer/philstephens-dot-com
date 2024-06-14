<?php

namespace App\Models;

use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model implements Feedable
{
    use HasFactory;
    use HasSlug;
    use Publishable;

    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
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
            ->summary($this->body)
            ->updated($this->updated_at)
            ->link(route('post.show', $this->slug))
            ->authorName('Phil Stephens')
            ->authorEmail('phils@hey.com');
    }

    public static function getFeedItems()
    {
        return Post::published()->get();
    }

}
