<?php

namespace App\Jobs;

use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateAuthorBooksCount implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $authorId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $authorId)
    {
        $this->authorId = $authorId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Update books_published count
        $author = Author::find($this->authorId);

        if ($author) {
            $author->books_published = $author->books()->count();
            $author->save();
        }
    }
}
