<?php

namespace App\Observers;

use App\Models\Book;
use App\Models\Post;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        $this->updateBookshelfPost();
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updated(Book $book): void
    {
        $this->updateBookshelfPost();
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        $this->updateBookshelfPost();
    }

    /**
     * Handle the Book "restored" event.
     */
    public function restored(Book $book): void
    {
        $this->updateBookshelfPost();
    }

    /**
     * Handle the Book "force deleted" event.
     */
    public function forceDeleted(Book $book): void
    {
        $this->updateBookshelfPost();
    }

    protected function updateBookshelfPost(): void
    {
        $latest = Book::published()->first();

        if ($post = Post::where('slug', 'bookshelf')->first()) {
            $post->updated_at = $latest->published_at;
            $post->save();
        }
    }
}
