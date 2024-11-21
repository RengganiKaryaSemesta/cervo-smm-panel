<?php

namespace App\Jobs;

use App\Enums\InstagramServiceType;
use App\Models\InstagramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;

class InstagramServiceJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    // public InstagramService $instagramService;
    public function __construct(public InstagramService $instagramService, public $comments = [])
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle() : void
    {
        $instagramServiceProcess = new \App\Services\Instagram\InstagramService;
        if ($this->instagramService->type == InstagramServiceType::Like) {
            $instagramServiceProcess->like($this->instagramService);
        }
    }
}
