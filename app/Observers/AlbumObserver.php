<?php

namespace App\Observers;

use App\Models\Album;

class AlbumObserver
{
    /**
     * Handle the Album "saving" event.
     */
    public function saving(Album $album): void
    {
        if (empty($album->album_artwork) && ! empty($album->listen_link)) {
            $domain = parse_url($album->listen_link, PHP_URL_HOST);

            if ($domain == 'album.link') {
                // Create a crawler
                // navigate to page
                // locate the img tag with alt attribute 'Album Artwork'
                // copy the image - save using the slug of the album + .jpeg
                // add path to $album->album_artwork
            }
        }
    }
}
