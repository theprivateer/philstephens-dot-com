<?php

use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $slugs = [
            'about', 'now', 'uses', 'bookshelf', 'blogroll', 'vs-code',
        ];

        foreach ($slugs as $slug) {
            $page = Page::where('slug', $slug)->first();

            if ($page) {
                Post::create([
                    'title' => $page->title,
                    'slug' => $slug,
                    'content' => $page->content,
                    'top_level' => true,
                    'created_at' => $page->created_at,
                    'updated_at' => $page->updated_at,
                ]);

                $page->update([
                    'redirects_to' => '/post/' . $slug,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
